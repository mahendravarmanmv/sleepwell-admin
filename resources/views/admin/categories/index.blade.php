@extends('admin.layouts.app')

@section('title', 'Categories')

@section('page_heading', 'Categories')

@section('breadcrumb')

    <li class="breadcrumb-item active">
        Categories
    </li>

@endsection

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h1 class="h3 mb-1">
                Categories
            </h1>

            <p class="text-muted mb-0">
                Manage SleepWell product categories and subcategories.
            </p>

        </div>

        <div>

            <a
                href="{{ route('admin.categories.create') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Add Category
            </a>

        </div>

    </div>


    <div class="card admin-card mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.categories.index') }}"
            >

                <div class="row g-2">

                    <div class="col-md-8 col-lg-9">

                        <label
                            for="search"
                            class="visually-hidden"
                        >
                            Search categories
                        </label>

                        <input
                            type="search"
                            name="search"
                            id="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Search by category name or slug..."
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
                                href="{{ route('admin.categories.index') }}"
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

            @if ($categories->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Category
                                </th>

                                <th>
                                    Slug
                                </th>

                                <th>
                                    Parent
                                </th>

                                <th>
                                    Subcategories
                                </th>

                                <th class="text-end pe-4">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($categories as $category)

                                <tr>

                                    <td class="ps-4">

                                        <div class="d-flex align-items-center gap-2">

                                            <span
                                                class="rounded bg-light d-inline-flex align-items-center justify-content-center"
                                                style="width: 38px; height: 38px;"
                                            >
                                                <i class="bi {{ $category->icon_class }}"></i>
                                            </span>

                                            <div>

                                                <a
                                                    href="{{ route('admin.categories.show', $category) }}"
                                                    class="fw-semibold text-decoration-none"
                                                >
                                                    {{ $category->name }}
                                                </a>

                                                <div class="small text-muted">
                                                    #{{ $category->id }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <code>
                                            {{ $category->slug }}
                                        </code>
                                    </td>

                                    <td>

                                        @if ($category->parent)

                                            <span class="badge text-bg-light">
                                                {{ $category->parent->name }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                Main category
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $category->subcategories_count }}
                                    </td>

                                    <td class="text-end pe-4">

                                        <div class="dropdown">

                                            <button
                                                class="btn btn-sm btn-light"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                <li>

                                                    <a
                                                        href="{{ route('admin.categories.show', $category) }}"
                                                        class="dropdown-item"
                                                    >
                                                        <i class="bi bi-eye me-2"></i>
                                                        View
                                                    </a>

                                                </li>

                                                <li>

                                                    <a
                                                        href="{{ route('admin.categories.edit', $category) }}"
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
                                                        action="{{ route('admin.categories.destroy', $category) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?');"
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

                    {{ $categories->links() }}

                </div>

            @else

                <div class="text-center py-5 px-3">

                    <i class="bi bi-folder2-open display-5 text-muted"></i>

                    <h5 class="mt-3">
                        No categories found
                    </h5>

                    <p class="text-muted mb-3">
                        @if ($search !== '')
                            No categories match your search.
                        @else
                            No categories have been created yet.
                        @endif
                    </p>

                    @if ($search === '')

                        <a
                            href="{{ route('admin.categories.create') }}"
                            class="btn btn-primary"
                        >
                            Add Category
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection