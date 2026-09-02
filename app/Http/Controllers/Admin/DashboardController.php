<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Counts
        |--------------------------------------------------------------------------
        */

        $productsCount = Product::count();

        $customersCount = User::count();

        $dealersCount = Dealer::count();

        $ordersCount = Order::count();

        $categoriesCount = Category::count();


        /*
        |--------------------------------------------------------------------------
        | Order Status Counts
        |--------------------------------------------------------------------------
        */

        $orderStatusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        /*
        |--------------------------------------------------------------------------
        | Payment Status Counts
        |--------------------------------------------------------------------------
        */

        $paymentStatusCounts = OrderPayment::query()
            ->selectRaw('payment_status, COUNT(*) as total')
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');


        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::query()
            ->with('user')
            ->latest('id')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Payments
        |--------------------------------------------------------------------------
        */

        $recentPayments = OrderPayment::query()
            ->with('order.user')
            ->latest('id')
            ->limit(5)
            ->get();


        return view('admin.dashboard', compact(
            'productsCount',
            'customersCount',
            'dealersCount',
            'ordersCount',
            'categoriesCount',
            'orderStatusCounts',
            'paymentStatusCounts',
            'recentOrders',
            'recentPayments'
        ));
    }
}