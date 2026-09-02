<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display customers.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $customers = User::query()
            ->withCount('orders')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.customers.index',
            compact('customers', 'search')
        );
    }

    /**
     * Display customer details.
     */
    public function show(User $customer): View
    {
        $customer->load([
            'orders' => function ($query) {
                $query->latest('id');
            },
        ]);

        return view(
            'admin.customers.show',
            compact('customer')
        );
    }
}