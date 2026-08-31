@extends('admin.layouts.app')

@section('title', 'Dealers')

@section('page_heading', 'Dealers')

@section('breadcrumb')

    <li class="breadcrumb-item active">
        Dealers
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Dealers
            </h1>

            <p class="text-muted mb-0">
                Manage SleepWell dealers.
            </p>

        </div>

        <a
            href="{{ route('admin.dealers.create') }}"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Dealer
        </a>

    </div>


    <div class="card admin-card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.dealers.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-8 col-lg-9">

                        <input
                            type="search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Search dealer name or city..."
                        >

                    </div>

                    <div class="col-md-4 col-lg-3 d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-outline-primary flex-grow-1"
                        >
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>

                        @if ($search !== '')

                            <a
                                href="{{ route('admin.dealers.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                Clear
                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>

    </div>


    <div class="card admin-card">

        <div class="card-body p-0">

            @if ($dealers->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Dealer
                                </th>

                                <th>
                                    City
                                </th>

                                <th>
                                    Verification
                                </th>

                                <th>
                                    Products
                                </th>

                                <th class="text-end pe-4">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($dealers as $dealer)

                                <tr>

                                    <td class="ps-4">

                                        <div class="d-flex align-items-center gap-3">

                                            <span
                                                class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                                style="width: 42px; height: 42px;"
                                            >
                                                <i class="bi bi-shop"></i>
                                            </span>

                                            <div>

                                                <a
                                                    href="{{ route('admin.dealers.show', $dealer) }}"
                                                    class="fw-semibold text-decoration-none"
                                                >
                                                    {{ $dealer->dealer_name }}
                                                </a>

                                                <div class="small text-muted">
                                                    #{{ $dealer->id }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td>

                                        @if ($dealer->city)

                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $dealer->city }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                Not specified
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if ($dealer->is_verified)

                                            <span class="badge text-bg-success">
                                                Verified
                                            </span>

                                        @else

                                            <span class="badge text-bg-secondary">
                                                Unverified
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $dealer->products_count }}
                                    </td>


                                    <td class="text-end pe-4">

                                        <div class="dropdown">

                                            <button
                                                class="btn btn-sm btn-light"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                            >
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                <li>
                                                    <a
                                                        href="{{ route('admin.dealers.show', $dealer) }}"
                                                        class="dropdown-item"
                                                    >
                                                        <i class="bi bi-eye me-2"></i>
                                                        View
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        href="{{ route('admin.dealers.edit', $dealer) }}"
                                                        class="dropdown-item"
                                                    >
                                                        <i class="bi bi-pencil me-2"></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>

                                                <li>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('admin.dealers.destroy', $dealer) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this dealer?');"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="dropdown-item text-danger"
                                                        >
                                                            <i class="bi bi-trash me-2"></i>
                                                            Delete
                                                        </button>

                                                    </form>

                                                </li>

                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                <div class="p-3 border-top">

                    {{ $dealers->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-shop display-5 text-muted"></i>

                    <h5 class="mt-3">
                        No dealers found
                    </h5>

                    <p class="text-muted">
                        @if ($search !== '')
                            No dealers match your search.
                        @else
                            No dealers have been added yet.
                        @endif
                    </p>

                    @if ($search === '')

                        <a
                            href="{{ route('admin.dealers.create') }}"
                            class="btn btn-primary"
                        >
                            Add Dealer
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection