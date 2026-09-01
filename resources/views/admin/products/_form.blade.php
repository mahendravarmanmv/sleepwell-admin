<div class="row g-4">

    {{-- Basic Information --}}
    <div class="col-12">

        <div class="card admin-card">

            <div class="card-header bg-white py-3">

                <h6 class="mb-0 fw-semibold">
                    Basic Information
                </h6>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <label
                            for="title"
                            class="form-label fw-semibold"
                        >
                            Product Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $product->title ?? '') }}"
                            maxlength="255"
                            required
                        >

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label
                            for="category_id"
                            class="form-label fw-semibold"
                        >
                            Category
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                Select Category
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old(
                                            'category_id',
                                            $product->category_id ?? null
                                        ) == $category->id
                                    )
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label
                            for="slug"
                            class="form-label fw-semibold"
                        >
                            Slug
                        </label>

                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $product->slug ?? '') }}"
                            maxlength="255"
                            required
                        >

                        <div class="form-text">
                            Example: premium-memory-foam-mattress
                        </div>

                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label
                            for="image_url"
                            class="form-label fw-semibold"
                        >
                            Main Image URL / Path
                        </label>

                        <input
                            type="text"
                            id="image_url"
                            name="image_url"
                            class="form-control @error('image_url') is-invalid @enderror"
                            value="{{ old('image_url', $product->image_url ?? '') }}"
                            maxlength="255"
                            placeholder="/images/products/product.jpg"
                        >

                        @error('image_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-12">

                        <label
                            for="description"
                            class="form-label fw-semibold"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="6"
                            class="form-control @error('description') is-invalid @enderror"
                        >{{ old('description', $product->description ?? '') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Pricing & Inventory --}}
    <div class="col-lg-7">

        <div class="card admin-card h-100">

            <div class="card-header bg-white py-3">

                <h6 class="mb-0 fw-semibold">
                    Pricing & Inventory
                </h6>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <label
                            for="price"
                            class="form-label fw-semibold"
                        >
                            Base Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="price"
                                id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price ?? '') }}"
                                required
                            >

                        </div>

                        @error('price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label
                            for="emi_starting_price"
                            class="form-label fw-semibold"
                        >
                            EMI Starting Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₹
                            </span>

                            <input
                                type="number"
                                min="0"
                                name="emi_starting_price"
                                id="emi_starting_price"
                                class="form-control @error('emi_starting_price') is-invalid @enderror"
                                value="{{ old('emi_starting_price', $product->emi_starting_price ?? '') }}"
                            >

                        </div>

                        @error('emi_starting_price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label
                            for="stock_quantity"
                            class="form-label fw-semibold"
                        >
                            Stock Quantity
                        </label>

                        <input
                            type="number"
                            min="0"
                            name="stock_quantity"
                            id="stock_quantity"
                            class="form-control @error('stock_quantity') is-invalid @enderror"
                            value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                            required
                        >

                        @error('stock_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6 d-flex align-items-end">

                        <div class="form-check form-switch mb-2">

                            <input
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                name="is_active"
                                id="is_active"
                                value="1"
                                @checked(
                                    old(
                                        'is_active',
                                        $product->is_active ?? true
                                    )
                                )
                            >

                            <label
                                class="form-check-label fw-semibold"
                                for="is_active"
                            >
                                Active Product
                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Badge --}}
    <div class="col-lg-5">

        <div class="card admin-card h-100">

            <div class="card-header bg-white py-3">

                <h6 class="mb-0 fw-semibold">
                    Product Badge
                </h6>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <label
                        for="badge_text"
                        class="form-label fw-semibold"
                    >
                        Badge Text
                    </label>

                    <input
                        type="text"
                        name="badge_text"
                        id="badge_text"
                        class="form-control"
                        value="{{ old('badge_text', $product->badge_text ?? '') }}"
                        maxlength="255"
                        placeholder="Best Seller"
                    >

                </div>


                <div>

                    <label
                        for="badge_color"
                        class="form-label fw-semibold"
                    >
                        Badge Color
                    </label>

                    <input
                        type="text"
                        name="badge_color"
                        id="badge_color"
                        class="form-control"
                        value="{{ old('badge_color', $product->badge_color ?? '') }}"
                        maxlength="50"
                        placeholder="#000000 or primary"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- Key Features --}}
    <div class="col-12">

        <div class="card admin-card">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="mb-0 fw-semibold">
                        Key Features
                    </h6>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        id="add-feature"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Add Feature
                    </button>

                </div>

            </div>

            <div class="card-body">

                <div id="features-container">

                    @php
                        $features = old(
                            'key_features',
                            $product->key_features ?? []
                        );

                        if (!is_array($features) || count($features) === 0) {
                            $features = [''];
                        }
                    @endphp

                    @foreach ($features as $index => $feature)

                        <div class="input-group mb-2 feature-row">

                            <input
                                type="text"
                                name="key_features[]"
                                class="form-control"
                                value="{{ $feature }}"
                                maxlength="500"
                                placeholder="Enter product feature"
                            >

                            <button
                                type="button"
                                class="btn btn-outline-danger remove-feature"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>

                    @endforeach

                </div>

                <div class="form-text">
                    Add the product highlights displayed on the customer-facing product page.
                </div>

            </div>

        </div>

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">

    <a
        href="{{ route('admin.products.index') }}"
        class="btn btn-outline-secondary"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary px-4"
    >
        {{ $submitLabel }}
    </button>

</div>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('features-container');
    const addButton = document.getElementById('add-feature');

    addButton.addEventListener('click', function () {

        const row = document.createElement('div');

        row.className = 'input-group mb-2 feature-row';

        row.innerHTML = `
            <input
                type="text"
                name="key_features[]"
                class="form-control"
                maxlength="500"
                placeholder="Enter product feature"
            >

            <button
                type="button"
                class="btn btn-outline-danger remove-feature"
            >
                <i class="bi bi-trash"></i>
            </button>
        `;

        container.appendChild(row);
    });


    container.addEventListener('click', function (event) {

        const button = event.target.closest('.remove-feature');

        if (!button) {
            return;
        }

        const rows = container.querySelectorAll('.feature-row');

        if (rows.length === 1) {
            rows[0].querySelector('input').value = '';
            return;
        }

        button.closest('.feature-row').remove();
    });

});
</script>

@endpush