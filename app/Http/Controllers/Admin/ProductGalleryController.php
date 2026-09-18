<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductGalleryController extends Controller
{
    public function index(Product $product): View
    {
        $product->load('galleryImages');

        return view('admin.products.gallery.index', compact(
            'product'
        ));
    }

	public function store(Request $request, Product $product): RedirectResponse
	{
	$validated = $request->validate([
	'image_url' => ['nullable', 'string', 'max:255'],
	'image_file' => [
		'nullable',
		'image',
		'mimes:jpg,jpeg,png,webp',
		'max:2048',
	],
	'sort_order' => ['nullable', 'integer', 'min:0'],
	]);

	if (
	empty($validated['image_url']) &&
	!$request->hasFile('image_file')
	) {
	return back()
		->withErrors([
			'image_url' => 'Please enter an image URL/path or upload an image.',
		])
		->withInput();
	}

	$imageUrl = $validated['image_url'] ?? null;

	if ($request->hasFile('image_file')) {
	$imageUrl = $this->storeGalleryImage(
		$request->file('image_file')
	);
	}

	$sortOrder = $validated['sort_order']
	?? ((int) $product->galleryImages()->max('sort_order') + 1);

	ProductImage::create([
	'product_id' => $product->id,
	'image_url' => $imageUrl,
	'sort_order' => $sortOrder,
	]);

	return redirect()
	->route('admin.products.gallery.index', $product)
	->with('success', 'Gallery image added successfully.');
	}

    public function update(
    Request $request,
    Product $product,
    ProductImage $image
): RedirectResponse {
    $this->ensureImageBelongsToProduct($product, $image);

    $validated = $request->validate([
        'image_url' => ['nullable', 'string', 'max:255'],
        'image_file' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'sort_order' => ['required', 'integer', 'min:0'],
    ]);

    if (
        empty($validated['image_url']) &&
        !$request->hasFile('image_file')
    ) {
        return back()
            ->withErrors([
                'image_url' => 'Please enter an image URL/path or upload an image.',
            ])
            ->withInput();
    }

    $oldImage = $image->image_url;

    $imageUrl = $validated['image_url'] ?? null;

    if ($request->hasFile('image_file')) {
        $imageUrl = $this->storeGalleryImage(
            $request->file('image_file')
        );
    }

    $image->update([
        'image_url' => $imageUrl,
        'sort_order' => $validated['sort_order'],
    ]);

    if (
        $request->hasFile('image_file') &&
        $oldImage &&
        str_starts_with($oldImage, '/images/products/')
    ) {
        $oldImagePath = config('sleepwell.frontend_public_path') . $oldImage;

        if (is_file($oldImagePath)) {
            @unlink($oldImagePath);
        }
    }

    return redirect()
        ->route('admin.products.gallery.index', $product)
        ->with('success', 'Gallery image updated successfully.');
}

	public function destroy(
	Product $product,
	ProductImage $image
	): RedirectResponse {
	$this->ensureImageBelongsToProduct($product, $image);

	$imageUrl = $image->image_url;

	$image->delete();

	if (
		$imageUrl &&
		str_starts_with($imageUrl, '/images/products/')
	) {
		$imagePath = config('sleepwell.frontend_public_path') . $imageUrl;

		if (is_file($imagePath)) {
			@unlink($imagePath);
		}
	}

	return redirect()
		->route('admin.products.gallery.index', $product)
		->with('success', 'Gallery image deleted successfully.');
	}

    private function ensureImageBelongsToProduct(
        Product $product,
        ProductImage $image
    ): void {
        abort_unless(
            $image->product_id === $product->id,
            404
        );
    }
	
	private function storeGalleryImage(UploadedFile $file): string
	{
	$directory = config('sleepwell.product_images_path');

	$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

	$file->move($directory, $filename);

	return '/images/products/' . $filename;
	}
}