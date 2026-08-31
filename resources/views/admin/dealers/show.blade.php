@extends('admin.layouts.app')

@section('title', $dealer->dealer_name)

@section('page_heading', 'Dealer Details')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.dealers.index') }}"
            class="text-decoration-none"
        >
            Dealers
        </a>
    </li>

    <li class="breadcrumb-item active">
        {{ $dealer->dealer_name }}
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $dealer->dealer_name }}
            </h1>

            <p class="text-muted mb-0">
                Dealer #{{ $dealer->id }}
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.dealers.edit', $dealer) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

            <a
                href="{{ route('admin.dealers.index') }}"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

        </div>

    </div>


    <div class="row g-4">

        <div class="col-lg-5">

            <div class="card admin-card">

                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        Dealer Information
                    </h6>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">

                        <dt class="col-sm-5">
                            Dealer Name
                        </dt>

                        <dd class="col-sm-7">
                            {{ $dealer->dealer_name }}
                        </dd>


                        <dt class="col-sm-5">
                            City
                        </dt>

                        <dd class="col-sm-7">
                            {{ $dealer->city ?: 'Not specified' }}
                        </dd>


                        <dt class="col-sm-5">
                            Verification
                        </dt>

                        <dd class="col-sm-7">

                            @if ($dealer->is_verified)

                                <span class="badge text-bg-success">
                                    Verified
                                </span>

                            @else

                                <span class="badge text-bg-secondary">
                                    Unverified
                                </span>

                            @endif

                        </dd>


                        <dt class="col-sm-5">
                            Products
                        </dt>

                        <dd class="col-sm-7">
                            {{ $dealer->products->count() }}
                        </dd>

                    </dl>

                </div>

            </div>

        </div>


        <div class="col-lg-7">

            <div class="card admin-card">

                <div class="card-header bg-white">

                    <h6 class="mb-0">
                        Associated Products
                    </h6>

                </div>

                <div class="card-body p-0">

                    @if ($dealer->products->count())

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="ps-4">
                                            Product
                                        </th>

                                        <th>
                                            Dealer Price
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($dealer->products as $product)

                                        <tr>

                                            <td class="ps-4">

                                                <span class="fw-semibold">
                                                    {{ $product->title }}
                                                </span>

                                                <div class="small text-muted">
                                                    #{{ $product->id }}
                                                </div>

                                            </td>

                                            <td>

                                                ₹{{ number_format(
                                                    $product->pivot->price,
                                                    2
                                                ) }}

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-muted text-center py-5">
                            No products are currently associated with this dealer.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection