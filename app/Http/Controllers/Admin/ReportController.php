<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->input('from');
        $to = $request->input('to');

        /*
        |--------------------------------------------------------------------------
        | Default Date Range
        |--------------------------------------------------------------------------
        */

        $fromDate = $from
            ? Carbon::parse($from)->startOfDay()
            : now()->startOfMonth();

        $toDate = $to
            ? Carbon::parse($to)->endOfDay()
            : now()->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | Orders Query
        |--------------------------------------------------------------------------
        */

        $ordersQuery = Order::query()
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Sales Summary
        |--------------------------------------------------------------------------
        */

        $totalOrders = (clone $ordersQuery)->count();

        $grossOrderValue = (clone $ordersQuery)->sum('total_amount');

        $cancelledOrderValue = (clone $ordersQuery)
            ->where('status', 'cancelled')
            ->sum('total_amount');

        $nonCancelledOrderValue = $grossOrderValue - $cancelledOrderValue;

        $averageOrderValue = $totalOrders > 0
            ? $grossOrderValue / $totalOrders
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Order Status Summary
        |--------------------------------------------------------------------------
        */

        $orderStatusCounts = (clone $ordersQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        $paymentsQuery = OrderPayment::query()
            ->whereHas('order', function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [
                    $fromDate,
                    $toDate,
                ]);
            });


        $paidAmount = (clone $paymentsQuery)
            ->where('payment_status', 'paid')
            ->sum('amount');

        $pendingPaymentAmount = (clone $paymentsQuery)
            ->where('payment_status', 'pending')
            ->sum('amount');

        $failedPaymentCount = (clone $paymentsQuery)
            ->where('payment_status', 'failed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Top Products
        |--------------------------------------------------------------------------
        */

        $topProducts = OrderItem::query()
            ->selectRaw(
                'product_id,
                 product_name,
                 SUM(quantity) as total_quantity,
                 SUM(line_total) as total_value'
            )
            ->whereHas('order', function ($query) use ($fromDate, $toDate) {
                $query
                    ->whereBetween('created_at', [
                        $fromDate,
                        $toDate,
                    ])
                    ->where('status', '!=', 'cancelled');
            })
            ->groupBy(
                'product_id',
                'product_name'
            )
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Daily Orders
        |--------------------------------------------------------------------------
        */

        $dailyOrders = (clone $ordersQuery)
            ->selectRaw(
                'DATE(created_at) as order_date,
                 COUNT(*) as total_orders,
                 SUM(total_amount) as total_value'
            )
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get();


        return view('admin.reports.index', compact(
            'from',
            'to',
            'fromDate',
            'toDate',
            'totalOrders',
            'grossOrderValue',
            'cancelledOrderValue',
            'nonCancelledOrderValue',
            'averageOrderValue',
            'orderStatusCounts',
            'paidAmount',
            'pendingPaymentAmount',
            'failedPaymentCount',
            'topProducts',
            'dailyOrders'
        ));
    }
}