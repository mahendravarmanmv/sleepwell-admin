<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $products = Product::query()
            ->with('category')
            ->withCount([
                'galleryImages',
                'packages',
                'warranties',
                'dealers',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact(
            'products',
            'search'
        ));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact(
            'categories'
        ));
    }

	public function store(StoreProductRequest $request): RedirectResponse
	{
	$data = $request->validated();

	$data['key_features'] = $this->cleanKeyFeatures(
		$data['key_features'] ?? []
	);

	if ($request->hasFile('image_file')) {
		$data['image_url'] = $this->storeProductImage(
			$request->file('image_file')
		);
	}

	unset($data['image_file']);

	$product = DB::transaction(
		fn () => Product::create($data)
	);

	return redirect()
		->route('admin.products.edit', $product)
		->with('success', 'Product created successfully.');
	}

    public function show(Product $product): View
    {
        $product->load([
            'category',
            'galleryImages',
            'packages',
            'warranties',
            'dealers',
        ]);

        return view('admin.products.show', compact(
            'product'
        ));
    }

    public function edit(Product $product): View
    {
        $product->load([
            'category',
            'galleryImages',
            'packages',
            'warranties',
            'dealers',
        ]);

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact(
            'product',
            'categories'
        ));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse 
	{
    $data = $request->validated();

    $data['key_features'] = $this->cleanKeyFeatures(
        $data['key_features'] ?? []
    );

    if ($request->hasFile('image_file')) {
        $oldImage = $product->image_url;

        $data['image_url'] = $this->storeProductImage(
            $request->file('image_file')
        );

        if (
            $oldImage &&
            str_starts_with($oldImage, '/images/products/')
        ) {
            $oldImagePath = config('sleepwell.frontend_public_path') . $oldImage;

            if (is_file($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }
    }

    unset($data['image_file']);

    DB::transaction(function () use ($product, $data) {
        $product->update($data);
    });

    return redirect()
        ->route('admin.products.edit', $product)
        ->with('success', 'Product updated successfully.');
	}

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orderItems()->exists()) {
            return back()->with(
                'error',
                'This product cannot be deleted because it has order history.'
            );
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function cleanKeyFeatures(array $features): array
    {
        return collect($features)
            ->map(fn ($feature) => trim((string) $feature))
            ->filter()
            ->values()
            ->all();
    }
	
	private function storeProductImage(UploadedFile $file): string
	{
	$directory = config('sleepwell.product_images_path');

	$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

	$file->move($directory, $filename);

	return '/images/products/' . $filename;
	}

}