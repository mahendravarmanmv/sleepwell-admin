@extends('admin.layouts.app')

@section('title', 'Product Packages')

@section('page_heading', 'Product Packages')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.products.index') }}"
            class="text-decoration-none"
        >
            Products
        </a>
    </li>

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.products.show', $product) }}"
            class="text-decoration-none"
        >
            {{ $product->title }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        Packages
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Product Packages
            </h1>

            <p class="text-muted mb-0">
                Manage packages available for {{ $product->title }}.
            </p>

        </div>

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route('admin.products.edit', $product) }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit Product
            </a>

            <a
                href="{{ route('admin.products.show', $product) }}"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

        </div>

    </div>


    {{-- Add Package --}}
    <div class="card admin-card mb-4">

        <div class="card-header bg-white py-3">

            <h6 class="mb-0 fw-semibold">
                Add Package
            </h6>

        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.products.packages.store', $product) }}"
            >

                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-lg-4">

                        <label
                            for="package_name"
                            class="form-label fw-semibold"
                        >
                            Package Name
                        </label>

                        <input
                            type="text"
                            name="package_name"
                            id="package_name"
                            class="form-control @error('package_name') is-invalid @enderror"
                            value="{{ old('package_name') }}"
                            maxlength="255"
                            placeholder="Standard Package"
                            required
                        >

                        @error('package_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-lg-3">

                        <label
                            for="price"
                            class="form-label fw-semibold"
                        >
                            Package Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>

                        @error('price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-lg-3">

                        <label
                            for="emi_starting_price"
                            class="form-label fw-semibold"
                        >
                            EMI Starting Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input
                                type="number"
                                name="emi_starting_price"
                                id="emi_starting_price"
                                class="form-control @error('emi_starting_price') is-invalid @enderror"
                                value="{{ old('emi_starting_price') }}"
                                min="0"
                            >

                        </div>

                        @error('emi_starting_price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-lg-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Add
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Existing Packages --}}
    <div class="card admin-card">

        <div class="card-header bg-white py-3">

            <h6 class="mb-0 fw-semibold">
                Existing Packages
            </h6>

        </div>

        <div class="card-body p-0">

            @if ($product->packages->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Package
                                </th>

                                <th>
                                    Price
                                </th>

                                <th>
                                    EMI Starting
                                </th>

                                <th class="text-end pe-4">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($product->packages as $package)

                                <tr>

                                    <td class="ps-4">

                                        <div class="fw-semibold">
                                            {{ $package->package_name }}
                                        </div>

                                        <div class="small text-muted">
                                            #{{ $package->id }}
                                        </div>

                                    </td>


                                    <td>

                                        ₹{{ number_format(
                                            $package->price,
                                            2
                                        ) }}

                                    </td>


                                    <td>

                                        @if ($package->emi_starting_price !== null)

                                            ₹{{ number_format(
                                                $package->emi_starting_price
                                            ) }}

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    <td class="text-end pe-4">

                                        <div class="d-flex justify-content-end gap-2">

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editPackage{{ $package->id }}"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.products.packages.destroy', [$product, $package]) }}"
                                                onsubmit="return confirm('Delete this package?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                {{-- Edit Modal --}}
                                <div
                                    class="modal fade"
                                    id="editPackage{{ $package->id }}"
                                    tabindex="-1"
                                    aria-hidden="true"
                                >

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form
                                                method="POST"
                                                action="{{ route('admin.products.packages.update', [$product, $package]) }}"
                                            >

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">

                                                    <h5 class="modal-title">
                                                        Edit Package
                                                    </h5>

                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                    ></button>

                                                </div>


                                                <div class="modal-body">

                                                    <div class="mb-3">

                                                        <label class="form-label fw-semibold">
                                                            Package Name
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="package_name"
                                                            class="form-control"
                                                            value="{{ $package->package_name }}"
                                                            maxlength="255"
                                                            required
                                                        >

                                                    </div>


                                                    <div class="mb-3">

                                                        <label class="form-label fw-semibold">
                                                            Price
                                                        </label>

                                                        <div class="input-group">

                                                            <span class="input-group-text">
                                                                ₹
                                                            </span>

                                                            <input
                                                                type="number"
                                                                name="price"
                                                                class="form-control"
                                                                value="{{ $package->price }}"
                                                                step="0.01"
                                                                min="0"
                                                                required
                                                            >

                                                        </div>

                                                    </div>


                                                    <div>

                                                        <label class="form-label fw-semibold">
                                                            EMI Starting Price
                                                        </label>

                                                        <div class="input-group">

                                                            <span class="input-group-text">
                                                                ₹
                                                            </span>

                                                            <input
                                                                type="number"
                                                                name="emi_starting_price"
                                                                class="form-control"
                                                                value="{{ $package->emi_starting_price }}"
                                                                min="0"
                                                            >

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="modal-footer">

                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >
                                                        Save Changes
                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-box display-5 text-muted"></i>

                    <h5 class="mt-3">
                        No packages configured
                    </h5>

                    <p class="text-muted mb-0">
                        Add a package using the form above.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection