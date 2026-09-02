<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $paymentStatus = $request->input('payment_status', '');
        $paymentMethod = $request->input('payment_method', '');

        $payments = OrderPayment::query()
            ->with([
                'order.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {

                    $query->where(
                        'transaction_reference',
                        'like',
                        "%{$search}%"
                    );

                    $query->orWhereHas('order', function ($query) use ($search) {

                        $query->where(
                            'order_number',
                            'like',
                            "%{$search}%"
                        );

                        $query->orWhereHas('user', function ($query) use ($search) {

                            $query->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                            $query->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            );

                            $query->orWhere(
                                'phone',
                                'like',
                                "%{$search}%"
                            );
                        });
                    });
                });
            })
            ->when($paymentStatus !== '', function ($query) use ($paymentStatus) {
                $query->where('payment_status', $paymentStatus);
            })
            ->when($paymentMethod !== '', function ($query) use ($paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $paymentStatuses = [
            'pending',
            'paid',
            'failed',
        ];

        $paymentMethods = OrderPayment::query()
            ->whereNotNull('payment_method')
            ->where('payment_method', '!=', '')
            ->distinct()
            ->orderBy('payment_method')
            ->pluck('payment_method');

        return view(
            'admin.payments.index',
            compact(
                'payments',
                'search',
                'paymentStatus',
                'paymentMethod',
                'paymentStatuses',
                'paymentMethods'
            )
        );
    }
}