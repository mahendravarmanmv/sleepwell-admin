@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">

        <h1 class="h3 mb-1">
            Reports & Analytics
        </h1>

        <p class="text-muted mb-0">
            Review SleepWell sales, orders and payment performance.
        </p>

    </div>


    {{-- Date Filter --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Report Period
            </h5>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.reports.index') }}">

                <div class="row align-items-end">

                    <div class="col-md-4 mb-3 mb-md-0">

                        <label class="form-label">
                            From
                        </label>

                        <input type="date"
                               name="from"
                               value="{{ $from }}"
                               class="form-control">

                    </div>


                    <div class="col-md-4 mb-3 mb-md-0">

                        <label class="form-label">
                            To
                        </label>

                        <input type="date"
                               name="to"
                               value="{{ $to }}"
                               class="form-control">

                    </div>


                    <div class="col-md-2 mb-3 mb-md-0">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Apply
                        </button>

                    </div>


                    <div class="col-md-2">

                        <a href="{{ route('admin.reports.index') }}"
                           class="btn btn-outline-secondary w-100">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Selected Period --}}
    <div class="alert alert-light border mb-4">

        <strong>Report period:</strong>

        {{ $fromDate->format('d M Y') }}
        -
        {{ $toDate->format('d M Y') }}

    </div>


    {{-- Sales Summary --}}
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Total Orders
                    </div>

                    <div class="h3 mb-0">
                        {{ number_format($totalOrders) }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Gross Order Value
                    </div>

                    <div class="h3 mb-0">
                        ₹{{ number_format($grossOrderValue, 2) }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Non-Cancelled Value
                    </div>

                    <div class="h3 mb-0">
                        ₹{{ number_format($nonCancelledOrderValue, 2) }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Average Order Value
                    </div>

                    <div class="h3 mb-0">
                        ₹{{ number_format($averageOrderValue, 2) }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Payment Summary --}}
    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Paid Amount
                    </div>

                    <div class="h3 mb-0">
                        ₹{{ number_format($paidAmount, 2) }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Pending Payment Amount
                    </div>

                    <div class="h3 mb-0">
                        ₹{{ number_format($pendingPaymentAmount, 2) }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Failed Payments
                    </div>

                    <div class="h3 mb-0">
                        {{ number_format($failedPaymentCount) }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Order Status + Top Products --}}
    <div class="row">


        {{-- Order Status --}}
        <div class="col-lg-5 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        Order Status
                    </h5>
                </div>

                <div class="card-body">

                    @php
                        $statuses = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'secondary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp

                    @foreach($statuses as $status => $badge)

                        <div class="d-flex justify-content-between
                                    align-items-center
                                    border-bottom
                                    py-3">

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


        {{-- Top Products --}}
        <div class="col-lg-7 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header">

                    <h5 class="mb-0">
                        Top Products
                    </h5>

                </div>

                <div class="card-body p-0">

                    @if($topProducts->count())

                        <div class="table-responsive">

                            <table class="table table-bordered
                                          table-hover mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Value</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($topProducts as $product)

                                        <tr>

                                            <td>
                                                {{ $product->product_name }}
                                            </td>

                                            <td>
                                                {{ number_format($product->total_quantity) }}
                                            </td>

                                            <td>
                                                ₹{{ number_format($product->total_value, 2) }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-4 text-center text-muted">
                            No product sales found for this period.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- Daily Order Summary --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Daily Order Summary
            </h5>

        </div>

        <div class="card-body p-0">

            @if($dailyOrders->count())

                <div class="table-responsive">

                    <table class="table table-bordered
                                  table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Date</th>
                                <th>Orders</th>
                                <th>Order Value</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($dailyOrders as $day)

                                <tr>

                                    <td>
                                        {{ \Carbon\Carbon::parse($day->order_date)->format('d M Y') }}
                                    </td>

                                    <td>
                                        {{ number_format($day->total_orders) }}
                                    </td>

                                    <td>
                                        ₹{{ number_format($day->total_value, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">
                    No orders found for this period.
                </div>

            @endif

        </div>

    </div>


    {{-- Cancelled Value --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <div class="text-muted small">
                        Cancelled Order Value
                    </div>

                    <div class="h4 mb-0">
                        ₹{{ number_format($cancelledOrderValue, 2) }}
                    </div>

                </div>

                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
                   class="btn btn-outline-danger">
                    View Cancelled Orders
                </a>

            </div>

        </div>

    </div>

</div>

@endsection