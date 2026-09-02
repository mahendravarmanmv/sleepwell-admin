@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Notifications
            </h1>

            <p class="text-muted mb-0">
                View notification history and delivery status.
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
                  action="{{ route('admin.notifications.index') }}">

                <div class="row">

                    <div class="col-lg-5 mb-2 mb-lg-0">

                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ $search }}"
                               placeholder="Order number, customer, recipient or notification type">

                    </div>


                    <div class="col-lg-3 mb-2 mb-lg-0">

                        <select name="channel"
                                class="form-control">

                            <option value="">
                                All Channels
                            </option>

                            @foreach($channels as $item)

                                <option value="{{ $item }}"
                                    {{ $channel === $item ? 'selected' : '' }}>

                                    {{ strtoupper($item) }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-2 mb-2 mb-lg-0">

                        <select name="status"
                                class="form-control">

                            <option value="">
                                All Statuses
                            </option>

                            @foreach($statuses as $item)

                                <option value="{{ $item }}"
                                    {{ $status === $item ? 'selected' : '' }}>

                                    {{ ucfirst($item) }}

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


    {{-- Notification List --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Notification History
            </h5>
        </div>

        <div class="card-body p-0">

            @if($notifications->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Notification</th>
                                <th>Channel</th>
                                <th>Recipient</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th width="80">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($notifications as $notification)

                                <tr>

                                    {{-- Order --}}
                                    <td>

                                        @if($notification->order)

                                            <strong>
                                                {{ $notification->order->order_number }}
                                            </strong>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Customer --}}
                                    <td>

                                        @if($notification->order?->user)

                                            <div>
                                                {{ $notification->order->user->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $notification->order->user->email }}
                                            </small>

                                        @else

                                            <span class="text-muted">
                                                —

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Notification --}}
                                    <td>
                                        {{ $notification->notification_type ?: '—' }}
                                    </td>


                                    {{-- Channel --}}
                                    <td>

                                        @if($notification->channel)

                                            <span class="badge badge-light border">
                                                {{ strtoupper($notification->channel) }}
                                            </span>

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Recipient --}}
                                    <td>
                                        {{ $notification->recipient ?: '—' }}
                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @php
                                            $statusClass = match($notification->status) {
                                                'sent',
                                                'success',
                                                'delivered' => 'badge-success',

                                                'failed',
                                                'error' => 'badge-danger',

                                                'pending' => 'badge-warning',

                                                default => 'badge-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($notification->status ?: 'Unknown') }}
                                        </span>

                                    </td>


                                    {{-- Sent At --}}
                                    <td>

                                        @if($notification->created_at)

                                            {{ $notification->created_at->format('d M Y H:i') }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        @if($notification->order)

                                            <a href="{{ route('admin.orders.show', $notification->order) }}"
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

                    {{ $notifications->links() }}

                </div>

            @else

                <div class="p-4 text-center text-muted">
                    No notification records found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection