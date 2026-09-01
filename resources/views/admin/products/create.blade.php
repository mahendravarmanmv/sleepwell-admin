@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('page_heading', 'Create Product')

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
        Create
    </li>

@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Create Product
        </h1>

        <p class="text-muted mb-0">
            Add a new product to the SleepWell catalog.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.products.store') }}"
    >

        @csrf

        @php
            $submitLabel = 'Create Product';
        @endphp

        @include('admin.products._form')

    </form>

@endsection