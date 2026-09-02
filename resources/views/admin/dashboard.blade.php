@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">

        <h1 class="h3 mb-1">
            Dashboard
        </h1>

        <p class="text-muted mb-0">
            Overview of your SleepWell store.
        </p>

    </div>


    {{-- Summary Cards --}}
    <div class="row">

        {{-- Products --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Products
                            </div>

                            <div class="h3 mb-0">
                                {{ number_format($productsCount) }}
                            </div>

                        </div>

                        <div class="text-primary">
                            <i class="bi bi-box-seam fs-2"></i>
                        </div>

                    </div>

                    <div class="mt-3">

                        <a href="{{ route('admin.products.index') }}"
                           class="small">
                            Manage Products →
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Customers --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Customers
                            </div>

                            <div class="h3 mb-0">
                                {{ number_format($customersCount) }}
                            </div>

                        </div>

                        <div class="text-success">
                            <i class="bi bi-people fs-2"></i>
                        </div>

                    </div>

                    <div class="mt-3">

                        <a href="{{ route('admin.customers.index') }}"
                           class="small">
                            View Customers →
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Dealers --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Dealers
                            </div>

                            <div class="h3 mb-0">
                                {{ number_format($dealersCount) }}
                            </div>

                        </div>

                        <div class="text-warning">
                            <i class="bi bi-shop fs-2"></i>
                        </div>

                    </div>

                    <div class="mt-3">

                        <a href="{{ route('admin.dealers.index') }}"
                           class="small">
                            Manage Dealers →
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Orders --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Orders
                            </div>

                            <div class="h3 mb-0">
                                {{ number_format($ordersCount) }}
                            </div>

                        </div>

                        <div class="text-danger">
                            <i class="bi bi-cart-check fs-2"></i>
                        </div>

                    </div>

                    <div class="mt-3">

                        <a href="{{ route('admin.orders.index') }}"
                           class="small">
                            View Orders →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Main Dashboard --}}
    <div class="row">


        {{-- Order Overview --}}
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header">

                    <h5 class="mb-0">
                        Order Overview
                    </h5>

                </div>

                <div class="card-body">

                    @php
                        $orderStatuses = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'secondary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp

                    @foreach($orderStatuses as $status => $badge)

                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <span>
                                {{ ucfirst($status) }}
                            </span>

                            <span class="badge badge-{{ $badge }}">
                                {{ number_format($orderStatusCounts[$status] ?? 0) }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- Payment Overview --}}
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header">

                    <h5 class="mb-0">
                        Payment Overview
                    </h5>

                </div>

                <div class="card-body">

                    @php
                        $paymentStatuses = [
                            'pending' => 'warning',
                            'paid' => 'success',
                            'failed' => 'danger',
                        ];
                    @endphp

                    @foreach($paymentStatuses as $status => $badge)

                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <span>
                                {{ ucfirst($status) }}
                            </span>

                            <span class="badge badge-{{ $badge }}">
                                {{ number_format($paymentStatusCounts[$status] ?? 0) }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    {{-- Recent Orders + Payments --}}
    <div class="row">


        {{-- Recent Orders --}}
        <div class="col-lg-7 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        Recent Orders
                    </h5>

                    <a href="{{ route('admin.orders.index') }}"
                       class="small">
                        View All
                    </a>

                </div>


                <div class="card-body p-0">

                    @if($recentOrders->count())

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th>Order</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($recentOrders as $order)

                                        <tr>

                                            <td>

                                                <a href="{{ route('admin.orders.show', $order) }}">
                                                    {{ $order->order_number }}
                                                </a>

                                            </td>

                                            <td>

                                                {{ $order->user?->name ?? '—' }}

                                            </td>

                                            <td>

                                                ₹{{ number_format($order->total_amount, 2) }}

                                            </td>

                                            <td>

                                                @php
                                                    $statusClass = match($order->status) {
                                                        'pending' => 'badge-warning',
                                                        'confirmed' => 'badge-info',
                                                        'processing' => 'badge-primary',
                                                        'shipped' => 'badge-secondary',
                                                        'delivered' => 'badge-success',
                                                        'cancelled' => 'badge-danger',
                                                        default => 'badge-light',
                                                    };
                                                @endphp

                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-4 text-center text-muted">
                            No orders found.
                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- Recent Payments --}}
        <div class="col-lg-5 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        Recent Payments
                    </h5>

                    <a href="{{ route('admin.payments.index') }}"
                       class="small">
                        View All
                    </a>

                </div>


                <div class="card-body p-0">

                    @if($recentPayments->count())

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th>Order</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($recentPayments as $payment)

                                        <tr>

                                            <td>

                                                @if($payment->order)

                                                    <a href="{{ route('admin.orders.show', $payment->order) }}">
                                                        {{ $payment->order->order_number }}
                                                    </a>

                                                @else

                                                    —

                                                @endif

                                            </td>

                                            <td>
                                                ₹{{ number_format($payment->amount, 2) }}
                                            </td>

                                            <td>

                                                @php
                                                    $paymentClass = match($payment->payment_status) {
                                                        'pending' => 'badge-warning',
                                                        'paid' => 'badge-success',
                                                        'failed' => 'badge-danger',
                                                        default => 'badge-secondary',
                                                    };
                                                @endphp

                                                <span class="badge {{ $paymentClass }}">
                                                    {{ ucfirst($payment->payment_status) }}
                                                </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-4 text-center text-muted">
                            No payment records found.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection