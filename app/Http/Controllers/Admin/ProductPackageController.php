<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPackageController extends Controller
{
    public function index(Product $product): View
    {
        $product->load('packages');

        return view(
            'admin.products.packages.index',
            compact('product')
        );
    }

    public function store(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $request->validate([
            'package_name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'emi_starting_price' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $product->packages()->create($validated);

        return redirect()
            ->route('admin.products.packages.index', $product)
            ->with('success', 'Package added successfully.');
    }

    public function update(
        Request $request,
        Product $product,
        ProductPackage $package
    ): RedirectResponse {
        $this->ensurePackageBelongsToProduct(
            $product,
            $package
        );

        $validated = $request->validate([
            'package_name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'emi_starting_price' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $package->update($validated);

        return redirect()
            ->route('admin.products.packages.index', $product)
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(
        Product $product,
        ProductPackage $package
    ): RedirectResponse {
        $this->ensurePackageBelongsToProduct(
            $product,
            $package
        );

        $package->delete();

        return redirect()
            ->route('admin.products.packages.index', $product)
            ->with('success', 'Package deleted successfully.');
    }

    private function ensurePackageBelongsToProduct(
        Product $product,
        ProductPackage $package
    ): void {
        abort_unless(
            $package->product_id === $product->id,
            404
        );
    }
}