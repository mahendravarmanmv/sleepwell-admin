<?php

namespace App\Http\Controllers\Admin;

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

    public function store(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $request->validate([
            'image_url' => [
                'required',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $sortOrder = $validated['sort_order']
            ?? ((int) $product->galleryImages()->max('sort_order') + 1);

        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => trim($validated['image_url']),
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
        $this->ensureImageBelongsToProduct(
            $product,
            $image
        );

        $validated = $request->validate([
            'image_url' => [
                'required',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $image->update([
            'image_url' => trim($validated['image_url']),
            'sort_order' => $validated['sort_order'],
        ]);

        return redirect()
            ->route('admin.products.gallery.index', $product)
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(
        Product $product,
        ProductImage $image
    ): RedirectResponse {
        $this->ensureImageBelongsToProduct(
            $product,
            $image
        );

        $image->delete();

        return redirect()
            ->route('admin.products.gallery.index', $product)
            ->with('success', 'Gallery image removed successfully.');
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
}