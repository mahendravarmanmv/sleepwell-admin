@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Order {{ $order->order_number }}
            </h1>

            <p class="text-muted mb-0">
                {{ $order->created_at
                    ? $order->created_at->format('d M Y H:i')
                    : '—' }}
            </p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-secondary">
            Back to Orders
        </a>

    </div>


    {{-- Customer + Order Status --}}
    <div class="row">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        Customer
                    </h5>
                </div>

                <div class="card-body">

                    @if($order->user)

                        <div class="mb-3">
                            <strong>Name</strong>
                            <div class="text-muted">
                                {{ $order->user->name }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Email</strong>
                            <div class="text-muted">
                                {{ $order->user->email }}
                            </div>
                        </div>

                        <div>
                            <strong>Phone</strong>
                            <div class="text-muted">
                                {{ $order->user->phone ?: '—' }}
                            </div>
                        </div>

                    @else

                        <span class="text-muted">
                            Customer record unavailable.
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-lg-6 mb-4">

    <div class="card shadow-sm h-100">

        <div class="card-header">
            <h5 class="mb-0">
                Order Status
            </h5>
        </div>

        <div class="card-body">

            <div class="mb-3">

                <strong>Current Status</strong>

                <div class="mt-1">

                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'badge-warning',
                            'confirmed' => 'badge-info',
                            'processing' => 'badge-primary',
                            'shipped' => 'badge-secondary',
                            'delivered' => 'badge-success',
                            'cancelled' => 'badge-danger',
                            default => 'badge-secondary',
                        };
                    @endphp

                    <span class="badge {{ $statusClass }}">
                        {{ ucfirst($order->status) }}
                    </span>

                </div>

            </div>


            @if(count($availableStatuses))

                <hr>

                <form method="POST"
                      action="{{ route('admin.orders.status.update', $order) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-group">

                        <label>
                            Update Status
                            <span class="text-danger">*</span>
                        </label>

                        <select name="status"
                                class="form-control"
                                required>

                            <option value="">
                                Select new status
                            </option>

                            @foreach($availableStatuses as $availableStatus)

                                <option value="{{ $availableStatus }}">
                                    {{ ucfirst($availableStatus) }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Notes
                        </label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="3"
                                  maxlength="1000"
                                  placeholder="Optional status note"></textarea>

                    </div>


                    <button type="submit"
                            class="btn btn-primary"
                            onclick="return confirm('Update this order status?');">

                        Update Status

                    </button>

                </form>

            @else

                <div class="alert alert-secondary mb-0">
                    This order has reached a final status and cannot be changed.
                </div>

            @endif


            <div class="mt-3">

                <strong>Payment</strong>

                <div class="text-muted">
                    {{ strtoupper($order->payment_method) }}
                    /
                    {{ ucfirst($order->payment_status) }}
                </div>

            </div>

        </div>

    </div>

</div>

    </div>


    {{-- Delivery Address --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Delivery Address
            </h5>
        </div>

        <div class="card-body">

            @if($order->address)

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <strong>Name</strong>

                        <div class="text-muted">
                            {{ $order->address->name }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Phone</strong>

                        <div class="text-muted">
                            {{ $order->address->phone }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Email</strong>

                        <div class="text-muted">
                            {{ $order->address->email ?: '—' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>City</strong>

                        <div class="text-muted">
                            {{ $order->address->city }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>State</strong>

                        <div class="text-muted">
                            {{ $order->address->state }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Pincode</strong>

                        <div class="text-muted">
                            {{ $order->address->pincode }}
                        </div>

                    </div>


                    <div class="col-12">

                        <strong>Address</strong>

                        <div class="text-muted">
                            {{ $order->address->address }}
                        </div>

                    </div>

                </div>

            @else

                <span class="text-muted">
                    No delivery address recorded.
                </span>

            @endif

        </div>

    </div>


    {{-- Order Items --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Order Items
            </h5>
        </div>

        <div class="card-body p-0">

            @if($order->items->count())

                <div class="table-responsive">

                    <table class="table table-bordered mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Product</th>
                                <th>Package</th>
                                <th>Warranty</th>
                                <th>Dealer</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Line Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($order->items as $item)

                                <tr>

                                    <td>

                                        <strong>
                                            {{ $item->product_name }}
                                        </strong>

                                        @if($item->product)
                                            <br>
                                            <small class="text-muted">
                                                Product #{{ $item->product_id }}
                                            </small>
                                        @endif

                                    </td>


                                    <td>
                                        {{ $item->package_name ?: '—' }}
                                    </td>


                                    <td>

                                        @if($item->warranty_years)

                                            {{ $item->warranty_years }}
                                            {{ $item->warranty_years == 1 ? 'Year' : 'Years' }}

                                            @if($item->warranty_price !== null)
                                                <br>
                                                <small class="text-muted">
                                                    ₹{{ number_format($item->warranty_price, 2) }}
                                                </small>
                                            @endif

                                        @else

                                            —

                                        @endif

                                    </td>


                                    <td>

                                        @if($item->dealer)

                                            {{ $item->dealer->dealer_name }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    <td>
                                        {{ $item->quantity }}
                                    </td>


                                    <td>
                                        ₹{{ number_format($item->unit_price, 2) }}
                                    </td>


                                    <td>
                                        ₹{{ number_format($item->line_total, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">
                    No order items found.
                </div>

            @endif

        </div>

    </div>


    {{-- Price Summary --}}
    <div class="row">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">
                        Price Summary
                    </h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>
                            ₹{{ number_format($order->subtotal, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>GST</span>
                        <strong>
                            ₹{{ number_format($order->gst_amount, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery</span>
                        <strong>
                            ₹{{ number_format($order->delivery_charge, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Installation</span>
                        <strong>
                            ₹{{ number_format($order->installation_charges, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <strong>
                            ₹{{ number_format($order->discount_amount, 2) }}
                        </strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <strong>
                            Total
                        </strong>

                        <strong class="h5 mb-0">
                            ₹{{ number_format($order->total_amount, 2) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- Payment --}}
        <div class="col-lg-6 mb-4">

    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Payment
            </h5>
        </div>

        <div class="card-body">

            <div class="mb-3">

                <strong>Method</strong>

                <div class="text-muted">
                    {{ strtoupper($order->payment_method) }}
                </div>

            </div>


            <div class="mb-3">

                <strong>Current Status</strong>

                <div class="mt-1">

                    @php
                        $paymentStatusClass = match($order->payment_status) {
                            'pending' => 'badge-warning',
                            'paid' => 'badge-success',
                            'failed' => 'badge-danger',
                            default => 'badge-secondary',
                        };
                    @endphp

                    <span class="badge {{ $paymentStatusClass }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>

                </div>

            </div>


            @if($order->payment)

                <div class="mb-3">

                    <strong>Amount</strong>

                    <div class="text-muted">
                        ₹{{ number_format($order->payment->amount, 2) }}
                    </div>

                </div>


                <div class="mb-3">

                    <strong>Transaction Reference</strong>

                    <div class="text-muted">
                        {{ $order->payment->transaction_reference ?: '—' }}
                    </div>

                </div>


                <div class="mb-3">

                    <strong>Paid At</strong>

                    <div class="text-muted">

                        @if($order->payment->paid_at)
                            {{ $order->payment->paid_at->format('d M Y H:i') }}
                        @else
                            Not paid
                        @endif

                    </div>

                </div>

            @endif


            <hr>


            <form method="POST"
                  action="{{ route('admin.orders.payment.update', $order) }}">

                @csrf
                @method('PUT')


                <div class="form-group">

                    <label>
                        Payment Status
                        <span class="text-danger">*</span>
                    </label>

                    <select name="payment_status"
                            class="form-control"
                            required>

                        <option value="pending"
                            {{ $order->payment_status === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="paid"
                            {{ $order->payment_status === 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="failed"
                            {{ $order->payment_status === 'failed' ? 'selected' : '' }}>
                            Failed
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Amount
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="amount"
                           class="form-control"
                           min="0"
                           step="0.01"
                           value="{{ $order->payment
                               ? $order->payment->amount
                               : $order->total_amount }}"
                           required>

                </div>


                <div class="form-group">

                    <label>
                        Transaction / Receipt Reference
                    </label>

                    <input type="text"
                           name="transaction_reference"
                           class="form-control"
                           maxlength="255"
                           value="{{ $order->payment?->transaction_reference }}">

                </div>


                <div class="form-group">

                    <label>
                        Paid At
                    </label>

                    <input type="datetime-local"
                           name="paid_at"
                           class="form-control"
                           value="{{ $order->payment?->paid_at
                               ? $order->payment->paid_at->format('Y-m-d\TH:i')
                               : '' }}">

                    <small class="form-text text-muted">
                        Required automatically when marking the payment as paid.
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Notes
                    </label>

                    <textarea name="notes"
                              class="form-control"
                              rows="3"
                              maxlength="1000"
                              placeholder="Optional payment notes">{{ $order->payment?->notes }}</textarea>

                </div>


                <button type="submit"
                        class="btn btn-primary"
                        onclick="return confirm('Update payment information?');">

                    Update Payment

                </button>

            </form>

        </div>

    </div>

</div>

    </div>


    {{-- Status History --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Status History
            </h5>
        </div>

        <div class="card-body">

            @if($order->statusHistories->count())

                @foreach($order->statusHistories as $history)

                    <div class="border-bottom pb-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                {{ ucfirst($history->status) }}
                            </strong>

                            <small class="text-muted">
                                {{ $history->created_at
                                    ? $history->created_at->format('d M Y H:i')
                                    : '—' }}
                            </small>

                        </div>

                        @if($history->notes)

                            <div class="text-muted mt-1">
                                {{ $history->notes }}
                            </div>

                        @endif

                    </div>

                @endforeach

            @else

                <div class="text-muted">
                    No status history found.
                </div>

            @endif

        </div>

    </div>


    {{-- Notifications --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Notification Logs
            </h5>
        </div>

        <div class="card-body p-0">

            @if($order->notificationLogs->count())

                <div class="table-responsive">

                    <table class="table table-bordered mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Channel</th>
                                <th>Recipient</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Sent At</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($order->notificationLogs as $log)

                                <tr>

                                    <td>
                                        {{ ucfirst($log->channel) }}
                                    </td>

                                    <td>
                                        {{ $log->recipient }}
                                    </td>

                                    <td>
                                        {{ $log->notification_type }}
                                    </td>

                                    <td>
                                        {{ ucfirst($log->status) }}
                                    </td>

                                    <td>
                                        {{ $log->sent_at
                                            ? $log->sent_at->format('d M Y H:i')
                                            : '—' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">
                    No notification logs found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection