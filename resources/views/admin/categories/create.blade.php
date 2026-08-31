@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('page_heading', 'Create Category')

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
        Create
    </li>

@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Create Category
        </h1>

        <p class="text-muted mb-0">
            Add a new SleepWell category.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.categories.store') }}"
    >

        @csrf

        @php
            $submitLabel = 'Create Category';
        @endphp

        @include('admin.categories._form')

    </form>

@endsection