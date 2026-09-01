@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('page_heading', 'Edit Product')

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
        Edit
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Edit Product
            </h1>

            <p class="text-muted mb-0">
                Update {{ $product->title }}.
            </p>

        </div>

		<div class="d-flex flex-wrap gap-2">

		<a
		href="{{ route('admin.products.gallery.index', $product) }}"
		class="btn btn-outline-primary"
		>
		<i class="bi bi-images me-1"></i>
		Gallery
		</a>

		<a
		href="{{ route('admin.products.show', $product) }}"
		class="btn btn-outline-secondary"
		>
		<i class="bi bi-eye me-1"></i>
		View Product
		</a>

		</div>

    </div>


    <form
        method="POST"
        action="{{ route('admin.products.update', $product) }}"
    >

        @csrf
        @method('PUT')

        @php
            $submitLabel = 'Update Product';
        @endphp

        @include('admin.products._form')

    </form>

@endsection