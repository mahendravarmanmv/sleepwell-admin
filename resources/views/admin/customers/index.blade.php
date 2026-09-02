@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Customers</h1>
            <p class="text-muted mb-0">
                Manage registered SleepWell customers.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.customers.index') }}">

                <div class="row">

                    <div class="col-md-10 mb-2 mb-md-0">
                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ $search }}"
                               placeholder="Search by name, email or phone">
                    </div>

                    <div class="col-md-2">
                        <button type="submit"
                                class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Customers --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Customer List
            </h5>
        </div>

        <div class="card-body p-0">

            @if($customers->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">
                            <tr>
                                <th width="8%">ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Email Verification</th>
                                <th>Orders</th>
                                <th>Registered</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($customers as $customer)

                                <tr>

                                    <td>
                                        {{ $customer->id }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $customer->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $customer->email }}
                                    </td>

                                    <td>
                                        {{ $customer->phone ?: '—' }}
                                    </td>

                                    <td>

                                        @if($customer->email_verified_at)
                                            <span class="badge badge-success">
                                                Verified
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                Not Verified
                                            </span>
                                        @endif

                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            {{ $customer->orders_count }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $customer->created_at
                                            ? $customer->created_at->format('d M Y')
                                            : '—' }}
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.customers.show', $customer) }}"
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
                    {{ $customers->links() }}
                </div>

            @else

                <div class="p-4 text-center text-muted">
                    No customers found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection