@extends('admin.layouts.app')

@section('title', $product->title)

@section('page_heading', 'Product Details')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.products.index') }}"
            class="text-decoration-none"
        >
            Products
        </a>
    </li>

    <li class="breadcrumb-item active">
        {{ $product->title }}
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $product->title }}
            </h1>

            <p class="text-muted mb-0">
                Product #{{ $product->id }}
            </p>

        </div>

		<div class="d-flex flex-wrap gap-2">

		<a
		href="{{ route('admin.products.gallery.index', $product) }}"
		class="btn btn-outline-primary"
		>
		<i class="bi bi-images me-1"></i>
		Manage Gallery
		</a>
		
		<a
		href="{{ route('admin.products.packages.index', $product) }}"
		class="btn btn-outline-primary"
		>
		<i class="bi bi-box me-1"></i>
		Manage Packages
		</a>
		
		<a
		href="{{ route('admin.products.warranties.index', $product) }}"
		class="btn btn-outline-primary"
		>
		<i class="bi bi-shield-check me-1"></i>
		Manage Warranties
		</a>
		
		<a
		href="{{ route('admin.products.dealers.index', $product) }}"
		class="btn btn-outline-primary"
		>
		<i class="bi bi-shop me-1"></i>
		Manage Dealers
		</a>

		<a
		href="{{ route('admin.products.edit', $product) }}"
		class="btn btn-primary"
		>
		<i class="bi bi-pencil me-1"></i>
		Edit
		</a>

		<a
		href="{{ route('admin.products.index') }}"
		class="btn btn-outline-secondary"
		>
		Back
		</a>

		</div>

    </div>


    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card admin-card mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">
                        Product Information
                    </h6>

                </div>

                <div class="card-body">

                    <dl class="row mb-0">

                        <dt class="col-sm-4">
                            Title
                        </dt>

                        <dd class="col-sm-8">
                            {{ $product->title }}
                        </dd>


                        <dt class="col-sm-4">
                            Category
                        </dt>

                        <dd class="col-sm-8">
                            {{ $product->category?->name ?? '—' }}
                        </dd>


                        <dt class="col-sm-4">
                            Slug
                        </dt>

                        <dd class="col-sm-8">
                            <code>{{ $product->slug }}</code>
                        </dd>


                        <dt class="col-sm-4">
                            Base Price
                        </dt>

                        <dd class="col-sm-8">
                            ₹{{ number_format($product->price, 2) }}
                        </dd>


                        <dt class="col-sm-4">
                            EMI Starting
                        </dt>

                        <dd class="col-sm-8">
                            ₹{{ number_format($product->emi_starting_price ?? 0) }}
                        </dd>


                        <dt class="col-sm-4">
                            Stock
                        </dt>

                        <dd class="col-sm-8">
                            {{ $product->stock_quantity }}
                        </dd>


                        <dt class="col-sm-4">
                            Status
                        </dt>

                        <dd class="col-sm-8">

                            @if ($product->is_active)

                                <span class="badge text-bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge text-bg-secondary">
                                    Inactive
                                </span>

                            @endif

                        </dd>

                    </dl>

                </div>

            </div>


            <div class="card admin-card mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">
                        Description
                    </h6>

                </div>

                <div class="card-body">

                    @if ($product->description)

                        {!! nl2br(e($product->description)) !!}

                    @else

                        <span class="text-muted">
                            No description available.
                        </span>

                    @endif

                </div>

            </div>


            <div class="card admin-card">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">
                        Key Features
                    </h6>

                </div>

                <div class="card-body">

                    @if (count($product->key_features ?? []))

                        <ul class="mb-0">

                            @foreach ($product->key_features as $feature)

                                <li class="mb-2">
                                    {{ $feature }}
                                </li>

                            @endforeach

                        </ul>

                    @else

                        <span class="text-muted">
                            No key features configured.
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card admin-card mb-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">
                        Main Image
                    </h6>

                </div>

                <div class="card-body text-center">

                    @if ($product->image_url)

                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->title }}"
                            class="img-fluid rounded"
                        >

                    @else

                        <div class="py-5 text-muted">
                            <i class="bi bi-image display-5"></i>

                            <div class="mt-2">
                                No main image.
                            </div>
                        </div>

                    @endif

                </div>

            </div>


            <div class="card admin-card">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-semibold">
                        Product Components
                    </h6>

                </div>

                <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <span>
            <i class="bi bi-images me-2 text-primary"></i>
            Gallery Images
        </span>

        <div class="d-flex align-items-center gap-2">

            <strong>
                {{ $product->galleryImages->count() }}
            </strong>

            <a
                href="{{ route('admin.products.gallery.index', $product) }}"
                class="btn btn-sm btn-outline-primary"
            >
                Manage
            </a>

        </div>

    </div>


    <div class="d-flex justify-content-between align-items-center mb-3">

        <span>
            <i class="bi bi-box me-2 text-primary"></i>
            Packages
        </span>

        <div class="d-flex align-items-center gap-2">

            <strong>
                {{ $product->packages->count() }}
            </strong>

            <a
                href="{{ route('admin.products.packages.index', $product) }}"
                class="btn btn-sm btn-outline-primary"
            >
                Manage
            </a>

        </div>

    </div>


    <div class="d-flex justify-content-between align-items-center mb-3">

        <span>
            <i class="bi bi-shield-check me-2 text-primary"></i>
            Warranties
        </span>

        <div class="d-flex align-items-center gap-2">

            <strong>
                {{ $product->warranties->count() }}
            </strong>

            <a
                href="{{ route('admin.products.warranties.index', $product) }}"
                class="btn btn-sm btn-outline-primary"
            >
                Manage
            </a>

        </div>

    </div>


    <div class="d-flex justify-content-between align-items-center">

        <span>
            <i class="bi bi-shop me-2 text-primary"></i>
            Dealers
        </span>

        <div class="d-flex align-items-center gap-2">

            <strong>
                {{ $product->dealers->count() }}
            </strong>

			<a
			href="{{ route('admin.products.dealers.index', $product) }}"
			class="btn btn-sm btn-outline-primary"
			>
			Manage
			</a>

        </div>

    </div>

</div>

            </div>

        </div>

    </div>

@endsection