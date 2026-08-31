<div class="row g-4">

    <div class="col-lg-8">

        <div class="card admin-card">

            <div class="card-body">

                <div class="mb-3">

                    <label for="name" class="form-label fw-semibold">
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $category->name ?? '') }}"
                        maxlength="255"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label for="slug" class="form-label fw-semibold">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $category->slug ?? '') }}"
                        maxlength="255"
                        required
                    >

                    <div class="form-text">
                        Use letters, numbers, hyphens and underscores only.
                    </div>

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label for="icon_class" class="form-label fw-semibold">
                        Bootstrap Icon Class
                    </label>

                    <input
                        type="text"
                        name="icon_class"
                        id="icon_class"
                        class="form-control @error('icon_class') is-invalid @enderror"
                        value="{{ old('icon_class', $category->icon_class ?? 'bi-tag') }}"
                        maxlength="255"
                        placeholder="bi-tag"
                    >

                    <div class="form-text">
                        Example: bi-tag, bi-house, bi-stars
                    </div>

                    @error('icon_class')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-0">

                    <label for="parent_id" class="form-label fw-semibold">
                        Parent Category
                    </label>

                    <select
                        name="parent_id"
                        id="parent_id"
                        class="form-select @error('parent_id') is-invalid @enderror"
                    >

                        <option value="">
                            — Main Category —
                        </option>

                        @foreach ($parentCategories as $parent)

                            <option
                                value="{{ $parent->id }}"
                                @selected(
                                    old(
                                        'parent_id',
                                        $category->parent_id ?? null
                                    ) == $parent->id
                                )
                            >
                                {{ $parent->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('parent_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    <div class="col-lg-4">

        <div class="card admin-card">

            <div class="card-body">

                <h6 class="fw-semibold mb-3">
                    Category Information
                </h6>

                <div class="small text-muted">

                    <p class="mb-2">
                        <strong>Main category:</strong>
                        No parent selected.
                    </p>

                    <p class="mb-0">
                        <strong>Subcategory:</strong>
                        Select a parent category.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">

    <a
        href="{{ route('admin.categories.index') }}"
        class="btn btn-outline-secondary"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        {{ $submitLabel }}
    </button>

</div>