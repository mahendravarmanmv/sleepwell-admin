@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Customer Details
            </h1>

            <p class="text-muted mb-0">
                {{ $customer->name }}
            </p>
        </div>

        <a href="{{ route('admin.customers.index') }}"
           class="btn btn-secondary">
            Back to Customers
        </a>

    </div>


    {{-- Customer Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Customer Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Name</strong>

                    <div class="text-muted">
                        {{ $customer->name }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Email</strong>

                    <div class="text-muted">
                        {{ $customer->email }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Phone</strong>

                    <div class="text-muted">
                        {{ $customer->phone ?: '—' }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Email Verification</strong>

                    <div>

                        @if($customer->email_verified_at)

                            <span class="badge badge-success">
                                Verified
                            </span>

                            <small class="text-muted ml-2">
                                {{ $customer->email_verified_at->format('d M Y H:i') }}
                            </small>

                        @else

                            <span class="badge badge-secondary">
                                Not Verified
                            </span>

                        @endif

                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Registered</strong>

                    <div class="text-muted">
                        {{ $customer->created_at
                            ? $customer->created_at->format('d M Y H:i')
                            : '—' }}
                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>Total Orders</strong>

                    <div class="text-muted">
                        {{ $customer->orders->count() }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Order History --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Order History
            </h5>
        </div>

        <div class="card-body p-0">

            @if($customer->orders->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($customer->orders as $order)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $order->order_number }}
                                        </strong>
                                    </td>

                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ strtoupper($order->payment_method) }}
                                        /
                                        {{ ucfirst($order->payment_status) }}
                                    </td>

                                    <td>
                                        ₹{{ number_format($order->total_amount, 2) }}
                                    </td>

                                    <td>
                                        {{ $order->created_at
                                            ? $order->created_at->format('d M Y H:i')
                                            : '—' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">
                    This customer has not placed any orders yet.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection