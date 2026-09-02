<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductWarranty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductWarrantyController extends Controller
{
    public function index(Product $product): View
    {
        $product->load('warranties');

        return view('admin.products.warranties.index', compact('product'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'warranty_years' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('product_warranties', 'warranty_years')
                    ->where(fn ($query) => $query->where('product_id', $product->id)),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $product->warranties()->create($validated);

        return redirect()
            ->route('admin.products.warranties.index', $product)
            ->with('success', 'Warranty added successfully.');
    }

    public function update(
        Request $request,
        Product $product,
        ProductWarranty $warranty
    ): RedirectResponse {
        abort_unless($warranty->product_id === $product->id, 404);

        $validated = $request->validate([
            'warranty_years' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('product_warranties', 'warranty_years')
                    ->where(fn ($query) => $query->where('product_id', $product->id))
                    ->ignore($warranty->id),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $warranty->update($validated);

        return redirect()
            ->route('admin.products.warranties.index', $product)
            ->with('success', 'Warranty updated successfully.');
    }

    public function destroy(
        Product $product,
        ProductWarranty $warranty
    ): RedirectResponse {
        abort_unless($warranty->product_id === $product->id, 404);

        $warranty->delete();

        return redirect()
            ->route('admin.products.warranties.index', $product)
            ->with('success', 'Warranty deleted successfully.');
    }
}