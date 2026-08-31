<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDealerRequest;
use App\Http\Requests\Admin\UpdateDealerRequest;
use App\Models\Dealer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $dealers = Dealer::query()
            ->withCount('products')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('dealer_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->orderBy('dealer_name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dealers.index', compact(
            'dealers',
            'search'
        ));
    }

    public function create(): View
    {
        return view('admin.dealers.create');
    }

    public function store(StoreDealerRequest $request): RedirectResponse
    {
        Dealer::create($request->validated());

        return redirect()
            ->route('admin.dealers.index')
            ->with('success', 'Dealer created successfully.');
    }

    public function show(Dealer $dealer): View
    {
        $dealer->load([
            'products' => fn ($query) => $query->orderBy('name'),
        ]);

        return view('admin.dealers.show', compact(
            'dealer'
        ));
    }

    public function edit(Dealer $dealer): View
    {
        return view('admin.dealers.edit', compact(
            'dealer'
        ));
    }

    public function update(
        UpdateDealerRequest $request,
        Dealer $dealer
    ): RedirectResponse {
        $dealer->update($request->validated());

        return redirect()
            ->route('admin.dealers.index')
            ->with('success', 'Dealer updated successfully.');
    }

    public function destroy(Dealer $dealer): RedirectResponse
    {
        if ($dealer->products()->exists()) {
            return back()->with(
                'error',
                'This dealer cannot be deleted because products are currently associated with it.'
            );
        }

        $dealer->delete();

        return redirect()
            ->route('admin.dealers.index')
            ->with('success', 'Dealer deleted successfully.');
    }
}