@extends('admin.layouts.app')

@section('title', 'Products')

@section('page_heading', 'Products')

@section('breadcrumb')

    <li class="breadcrumb-item active">
        Products
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Products
            </h1>

            <p class="text-muted mb-0">
                Manage SleepWell products, inventory and product content.
            </p>

        </div>

        <a
            href="{{ route('admin.products.create') }}"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Product
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- SEARCH --}}
    {{-- ========================================================= --}}

    <div class="card admin-card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.products.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-9">

                        <input
                            type="search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Search product title or slug..."
                        >

                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-outline-primary flex-grow-1"
                        >
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>

                        @if ($search !== '')

                            <a
                                href="{{ route('admin.products.index') }}"
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


    {{-- ========================================================= --}}
    {{-- PRODUCTS --}}
    {{-- ========================================================= --}}

    <div class="card admin-card">

        <div class="card-body p-0">

            @if ($products->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Product
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Price
                                </th>

                                <th>
                                    Stock
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Related
                                </th>

                                <th class="text-end pe-4">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($products as $product)

                                <tr>

                                    {{-- ================================================= --}}
                                    {{-- PRODUCT --}}
                                    {{-- ================================================= --}}

                                    <td class="ps-4">

                                        <div class="d-flex align-items-center gap-3">

                                            @if ($product->image_url)

                                                <img
                                                    src="{{ config('sleepwell.frontend_url') . $product->image_url }}"
                                                    alt="{{ $product->title }}"
                                                    class="rounded object-fit-cover"
                                                    width="52"
                                                    height="52"
                                                >

                                            @else

                                                <span
                                                    class="rounded bg-light d-inline-flex align-items-center justify-content-center"
                                                    style="width: 52px; height: 52px;"
                                                >
                                                    <i class="bi bi-box-seam"></i>
                                                </span>

                                            @endif


                                            <div>

                                                <a
                                                    href="{{ route('admin.products.show', $product) }}"
                                                    class="fw-semibold text-decoration-none"
                                                >
                                                    {{ $product->title }}
                                                </a>

                                                <div class="small text-muted">
                                                    #{{ $product->id }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- CATEGORY --}}
                                    {{-- ================================================= --}}

                                    <td>
                                        {{ $product->category?->name ?? '—' }}
                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- PRICE --}}
                                    {{-- ================================================= --}}

                                    <td>
                                        ₹{{ number_format($product->price, 2) }}
                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- STOCK --}}
                                    {{-- ================================================= --}}

                                    <td>

                                        @if ($product->stock_quantity > 0)

                                            <span class="fw-semibold">
                                                {{ $product->stock_quantity }}
                                            </span>

                                        @else

                                            <span class="text-danger fw-semibold">
                                                Out of stock
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- STATUS --}}
                                    {{-- ================================================= --}}

                                    <td>

                                        @if ($product->is_active)

                                            <span class="badge text-bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge text-bg-secondary">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- RELATED --}}
                                    {{-- ================================================= --}}

                                    <td>

                                        <div class="small">

                                            <span class="me-2">
                                                <i class="bi bi-images"></i>
                                                {{ $product->gallery_images_count }}
                                            </span>

                                            <span class="me-2">
                                                <i class="bi bi-box"></i>
                                                {{ $product->packages_count }}
                                            </span>

                                            <span class="me-2">
                                                <i class="bi bi-shield-check"></i>
                                                {{ $product->warranties_count }}
                                            </span>

                                            <span>
                                                <i class="bi bi-shop"></i>
                                                {{ $product->dealers_count }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- ACTIONS --}}
                                    {{-- ================================================= --}}

                                    <td class="text-end pe-4">

                                        <div
                                            class="btn-group"
                                            role="group"
                                            aria-label="Product actions"
                                        >

                                            {{-- View --}}
                                            <a
                                                href="{{ route('admin.products.show', $product) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="View Product"
                                                aria-label="View Product"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>


                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Edit Product"
                                                aria-label="Edit Product"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </a>


                                            {{-- Delete --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.products.destroy', $product) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete Product"
                                                    aria-label="Delete Product"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- ================================================= --}}
                {{-- PAGINATION --}}
                {{-- ================================================= --}}

                <div class="p-3 border-top">

                    {{ $products->links() }}

                </div>

            @else

                {{-- ================================================= --}}
                {{-- NO PRODUCTS --}}
                {{-- ================================================= --}}

                <div class="text-center py-5">

                    <i class="bi bi-box-seam display-5 text-muted"></i>

                    <h5 class="mt-3">
                        No products found
                    </h5>

                    <p class="text-muted">

                        @if ($search !== '')

                            No products match your search.

                        @else

                            No products have been created yet.

                        @endif

                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection