@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Payments
            </h1>

            <p class="text-muted mb-0">
                View and manage order payment records.
            </p>
        </div>

    </div>


    {{-- Filters --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Search & Filter
            </h5>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.payments.index') }}">

                <div class="row">

                    <div class="col-lg-5 mb-2 mb-lg-0">

                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ $search }}"
                               placeholder="Order number, customer or transaction reference">

                    </div>


                    <div class="col-lg-3 mb-2 mb-lg-0">

                        <select name="payment_status"
                                class="form-control">

                            <option value="">
                                All Payment Statuses
                            </option>

                            @foreach($paymentStatuses as $status)

                                <option value="{{ $status }}"
                                    {{ $paymentStatus === $status ? 'selected' : '' }}>

                                    {{ ucfirst($status) }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-2 mb-2 mb-lg-0">

                        <select name="payment_method"
                                class="form-control">

                            <option value="">
                                All Methods
                            </option>

                            @foreach($paymentMethods as $method)

                                <option value="{{ $method }}"
                                    {{ $paymentMethod === $method ? 'selected' : '' }}>

                                    {{ strtoupper($method) }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-2">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Filter
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Payment List --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Payment List
            </h5>

        </div>


        <div class="card-body p-0">

            @if($payments->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Reference</th>
                                <th>Paid At</th>
                                <th width="80">Action</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($payments as $payment)

                                <tr>

                                    {{-- Order --}}
                                    <td>

                                        @if($payment->order)

                                            <strong>
                                                {{ $payment->order->order_number }}
                                            </strong>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Customer --}}
                                    <td>

                                        @if($payment->order?->user)

                                            <div>
                                                {{ $payment->order->user->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $payment->order->user->email }}
                                            </small>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Method --}}
                                    <td>
                                        {{ strtoupper($payment->payment_method) }}
                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @php
                                            $paymentStatusClass = match($payment->payment_status) {
                                                'pending' => 'badge-warning',
                                                'paid' => 'badge-success',
                                                'failed' => 'badge-danger',
                                                default => 'badge-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $paymentStatusClass }}">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>

                                    </td>


                                    {{-- Amount --}}
                                    <td>
                                        ₹{{ number_format($payment->amount, 2) }}
                                    </td>


                                    {{-- Reference --}}
                                    <td>
                                        {{ $payment->transaction_reference ?: '—' }}
                                    </td>


                                    {{-- Paid At --}}
                                    <td>

                                        @if($payment->paid_at)

                                            {{ $payment->paid_at->format('d M Y H:i') }}

                                        @else

                                            <span class="text-muted">
                                                Not paid
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        @if($payment->order)

                                            <a href="{{ route('admin.orders.show', $payment->order) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>

                                        @else

                                            —

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="p-3">

                    {{ $payments->links() }}

                </div>


            @else

                <div class="p-4 text-center text-muted">
                    No payment records found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection