@extends('admin.layouts.app')

@section('title', $category->name)

@section('page_heading', 'Category Details')

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
        {{ $category->name }}
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                {{ $category->name }}
            </h1>

            <p class="text-muted mb-0">
                Category #{{ $category->id }}
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.categories.edit', $category) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

            <a
                href="{{ route('admin.categories.index') }}"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

        </div>

    </div>


    <div class="row g-4">

        <div class="col-lg-6">

            <div class="card admin-card h-100">

                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        Category Information
                    </h6>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">

                        <dt class="col-sm-4">
                            Name
                        </dt>

                        <dd class="col-sm-8">
                            {{ $category->name }}
                        </dd>


                        <dt class="col-sm-4">
                            Slug
                        </dt>

                        <dd class="col-sm-8">
                            <code>{{ $category->slug }}</code>
                        </dd>


                        <dt class="col-sm-4">
                            Icon
                        </dt>

                        <dd class="col-sm-8">
                            <i class="bi {{ $category->icon_class }} me-1"></i>
                            {{ $category->icon_class }}
                        </dd>


                        <dt class="col-sm-4">
                            Parent
                        </dt>

                        <dd class="col-sm-8">

                            @if ($category->parent)

                                <a
                                    href="{{ route('admin.categories.show', $category->parent) }}"
                                    class="text-decoration-none"
                                >
                                    {{ $category->parent->name }}
                                </a>

                            @else

                                Main category

                            @endif

                        </dd>


                        <dt class="col-sm-4">
                            Created
                        </dt>

                        <dd class="col-sm-8">
                            {{ $category->created_at?->format('d M Y, h:i A') }}
                        </dd>


                        <dt class="col-sm-4">
                            Updated
                        </dt>

                        <dd class="col-sm-8">
                            {{ $category->updated_at?->format('d M Y, h:i A') }}
                        </dd>

                    </dl>

                </div>

            </div>

        </div>


        <div class="col-lg-6">

            <div class="card admin-card h-100">

                <div class="card-header bg-white">

                    <h6 class="mb-0">
                        Subcategories
                    </h6>

                </div>

                <div class="card-body">

                    @if ($category->subcategories->count())

                        <div class="list-group list-group-flush">

                            @foreach ($category->subcategories as $subcategory)

                                <a
                                    href="{{ route('admin.categories.show', $subcategory) }}"
                                    class="list-group-item list-group-item-action px-0 d-flex justify-content-between align-items-center"
                                >

                                    <span>

                                        <i class="bi {{ $subcategory->icon_class }} me-2"></i>

                                        {{ $subcategory->name }}

                                    </span>

                                    <i class="bi bi-chevron-right small"></i>

                                </a>

                            @endforeach

                        </div>

                    @else

                        <div class="text-muted">
                            This category has no subcategories.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection