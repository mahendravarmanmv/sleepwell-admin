@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Orders</h1>

            <p class="text-muted mb-0">
                Manage customer orders and order status.
            </p>
        </div>

    </div>


    {{-- Search / Filter --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.orders.index') }}">

                <div class="row">

                    <div class="col-md-7 mb-2 mb-md-0">

                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ $search }}"
                               placeholder="Search by order number, customer name, email or phone">

                    </div>


                    <div class="col-md-3 mb-2 mb-md-0">

                        <select name="status"
                                class="form-control">

                            <option value="">
                                All Statuses
                            </option>

                            @foreach($statuses as $orderStatus)

                                <option value="{{ $orderStatus }}"
                                    {{ $status === $orderStatus ? 'selected' : '' }}>

                                    {{ ucfirst($orderStatus) }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-2">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Filter
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Order List --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Order List
            </h5>
        </div>

        <div class="card-body p-0">

            @if($orders->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th width="80">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($orders as $order)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $order->order_number }}
                                        </strong>
                                    </td>


                                    <td>

                                        @if($order->user)

                                            <div>
                                                {{ $order->user->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $order->user->email }}
                                            </small>

                                        @else

                                            <span class="text-muted">
                                                Customer unavailable
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $order->items_count }}
                                    </td>


                                    <td>
                                        ₹{{ number_format($order->total_amount, 2) }}
                                    </td>


                                    <td>

                                        <div>
                                            {{ strtoupper($order->payment_method) }}
                                        </div>

                                        <small class="text-muted">
                                            {{ ucfirst($order->payment_status) }}
                                        </small>

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
                                                default => 'badge-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>

                                    </td>


                                    <td>
                                        {{ $order->created_at
                                            ? $order->created_at->format('d M Y H:i')
                                            : '—' }}
                                    </td>


                                    <td>

                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="p-3">
                    {{ $orders->links() }}
                </div>


            @else

                <div class="p-4 text-center text-muted">
                    No orders found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection