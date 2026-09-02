<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductDealerController extends Controller
{
    public function index(Product $product): View
    {
        $product->load('dealers');

        $dealers = Dealer::query()
            ->orderBy('dealer_name')
            ->get();

        $assignedDealerIds = $product->dealers
            ->pluck('id')
            ->toArray();

        return view(
            'admin.products.dealers.index',
            compact('product', 'dealers', 'assignedDealerIds')
        );
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'dealer_id' => [
                'required',
                'integer',
                Rule::exists('dealers', 'id'),
                Rule::unique('dealer_product', 'dealer_id')
                    ->where(fn ($query) => $query->where('product_id', $product->id)),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $product->dealers()->attach(
            $validated['dealer_id'],
            [
                'price' => $validated['price'],
            ]
        );

        return redirect()
            ->route('admin.products.dealers.index', $product)
            ->with('success', 'Dealer assigned successfully.');
    }

    public function update(
        Request $request,
        Product $product,
        Dealer $dealer
    ): RedirectResponse {
        $validated = $request->validate([
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $exists = $product->dealers()
            ->where('dealers.id', $dealer->id)
            ->exists();

        abort_unless($exists, 404);

        $product->dealers()->updateExistingPivot(
            $dealer->id,
            [
                'price' => $validated['price'],
            ]
        );

        return redirect()
            ->route('admin.products.dealers.index', $product)
            ->with('success', 'Dealer price updated successfully.');
    }

    public function destroy(
        Product $product,
        Dealer $dealer
    ): RedirectResponse {
        $exists = $product->dealers()
            ->where('dealers.id', $dealer->id)
            ->exists();

        abort_unless($exists, 404);

        $product->dealers()->detach($dealer->id);

        return redirect()
            ->route('admin.products.dealers.index', $product)
            ->with('success', 'Dealer removed from product successfully.');
    }
}