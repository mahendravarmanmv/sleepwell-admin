@extends('admin.layouts.app')

@section('title', 'Product Gallery')

@section('page_heading', 'Product Gallery')

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
        Gallery
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Product Gallery
            </h1>

            <p class="text-muted mb-0">
                Manage gallery images for {{ $product->title }}.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.products.edit', $product) }}"
                class="btn btn-outline-secondary"
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


    {{-- Add Image --}}
    <div class="card admin-card mb-4">

        <div class="card-header bg-white py-3">

            <h6 class="mb-0 fw-semibold">
                Add Gallery Image
            </h6>

        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.products.gallery.store', $product) }}"
            >

                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-lg-8">

                        <label
                            for="image_url"
                            class="form-label fw-semibold"
                        >
                            Image URL / Path
                        </label>

                        <input
                            type="text"
                            name="image_url"
                            id="image_url"
                            class="form-control @error('image_url') is-invalid @enderror"
                            value="{{ old('image_url') }}"
                            placeholder="/images/products/gallery/image.jpg"
                            required
                        >

                        @error('image_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-lg-2">

                        <label
                            for="sort_order"
                            class="form-label fw-semibold"
                        >
                            Sort Order
                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            id="sort_order"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', $product->galleryImages->count()) }}"
                            min="0"
                        >

                        @error('sort_order')
                            <div class="invalid-feedback">
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
                            Add Image
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Gallery --}}
    <div class="card admin-card">

		<div class="card-header bg-white py-3">

		<div class="d-flex justify-content-between align-items-center">

		<h6 class="mb-0 fw-semibold">
			Gallery Images
		</h6>

		<span class="badge text-bg-light">
			{{ $product->galleryImages->count() }} images
		</span>

		</div>

		</div>


        <div class="card-body">

            @if ($product->galleryImages->count())

                <div class="row g-4">

                    @foreach ($product->galleryImages as $image)

                        <div class="col-md-6 col-xl-4">

                            <div class="card h-100 border">

                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 220px;"
                                >

                                    <img
                                        src="{{ $image->image_url }}"
                                        alt="{{ $product->title }}"
                                        class="img-fluid"
                                        style="max-height: 220px; max-width: 100%; object-fit: contain;"
                                    >

                                </div>


                                <div class="card-body">

                                    <div class="small text-muted mb-2">
                                        Image #{{ $image->id }}
                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.products.gallery.update', [$product, $image]) }}"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">

                                            <label class="form-label small fw-semibold">
                                                Image URL / Path
                                            </label>

                                            <input
                                                type="text"
                                                name="image_url"
                                                class="form-control form-control-sm"
                                                value="{{ $image->image_url }}"
                                                required
                                            >

                                        </div>


                                        <div class="mb-3">

                                            <label class="form-label small fw-semibold">
                                                Sort Order
                                            </label>

                                            <input
                                                type="number"
                                                name="sort_order"
                                                class="form-control form-control-sm"
                                                value="{{ $image->sort_order }}"
                                                min="0"
                                                required
                                            >

                                        </div>


                                        <div class="d-flex gap-2">

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-primary flex-grow-1"
                                            >
                                                <i class="bi bi-check-lg me-1"></i>
                                                Save
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="document.getElementById('delete-image-{{ $image->id }}').submit();"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>

                                    </form>


                                    <form
                                        id="delete-image-{{ $image->id }}"
                                        method="POST"
                                        action="{{ route('admin.products.gallery.destroy', [$product, $image]) }}"
                                        class="d-none"
                                    >

                                        @csrf
                                        @method('DELETE')

                                    </form>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-images display-5 text-muted"></i>

                    <h5 class="mt-3">
                        No gallery images
                    </h5>

                    <p class="text-muted mb-0">
                        Add the first gallery image using the form above.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection