@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('page_heading', 'Edit Category')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.categories.index') }}"
            class="text-decoration-none"
        >
            Categories
        </a>
    </li>

    <li class="breadcrumb-item active">
        Edit
    </li>

@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Edit Category
        </h1>

        <p class="text-muted mb-0">
            Update {{ $category->name }}.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.categories.update', $category) }}"
    >

        @csrf
        @method('PUT')

        @php
            $submitLabel = 'Update Category';
        @endphp

        @include('admin.categories._form')

    </form>

@endsection