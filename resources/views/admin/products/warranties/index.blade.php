@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Product Warranties</h1>

            <p class="text-muted mb-0">
                Manage warranties for
                <strong>{{ $product->title }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.products.show', $product) }}"
           class="btn btn-secondary">
            Back to Product
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>
    @endif


    {{-- Add Warranty --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Add Warranty
            </h5>
        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.products.warranties.store', $product) }}">

                @csrf

                <div class="row">

                    {{-- Warranty Years --}}
                    <div class="col-md-5 mb-3">

                        <label for="warranty_years"
                               class="form-label">
                            Warranty Years
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               id="warranty_years"
                               name="warranty_years"
                               class="form-control @error('warranty_years') is-invalid @enderror"
                               min="1"
                               step="1"
                               value="{{ old('warranty_years') }}"
                               required>

                        @error('warranty_years')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Price --}}
                    <div class="col-md-5 mb-3">

                        <label for="price"
                               class="form-label">
                            Price
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               id="price"
                               name="price"
                               class="form-control @error('price') is-invalid @enderror"
                               min="0"
                               step="0.01"
                               value="{{ old('price') }}"
                               required>

                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Add Button --}}
                    <div class="col-md-2 mb-3 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Add Warranty
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- Existing Warranties --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Existing Warranties
            </h5>
        </div>

        <div class="card-body p-0">

            @if($product->warranties->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="10%">
                                    ID
                                </th>

                                <th>
                                    Warranty
                                </th>

                                <th>
                                    Price
                                </th>

                                <th width="220">
                                    Actions
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($product->warranties as $warranty)

                                <tr>

                                    {{-- ID --}}
                                    <td>
                                        {{ $warranty->id }}
                                    </td>


                                    {{-- Warranty --}}
                                    <td>

                                        {{ $warranty->warranty_years }}

                                        {{ $warranty->warranty_years == 1 ? 'Year' : 'Years' }}

                                    </td>


                                    {{-- Price --}}
                                    <td>
                                        ₹{{ number_format($warranty->price, 2) }}
                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        {{-- Edit --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editWarranty{{ $warranty->id }}">
                                            Edit
                                        </button>


                                        {{-- Delete --}}
                                        <form method="POST"
                                              action="{{ route('admin.products.warranties.destroy', [$product, $warranty]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this warranty?');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">

                    No warranties have been added for this product yet.

                </div>

            @endif

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- Edit Warranty Modals                                      --}}
{{-- IMPORTANT: Modals are outside the table                   --}}
{{-- ========================================================= --}}

@if($product->warranties->count())

    @foreach($product->warranties as $warranty)

        <div class="modal fade"
             id="editWarranty{{ $warranty->id }}"
             tabindex="-1"
             aria-labelledby="editWarrantyLabel{{ $warranty->id }}"
             aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form method="POST"
                          action="{{ route('admin.products.warranties.update', [$product, $warranty]) }}">

                        @csrf

                        @method('PUT')


                        {{-- Modal Header --}}
                        <div class="modal-header">

                            <h5 class="modal-title"
                                id="editWarrantyLabel{{ $warranty->id }}">

                                Edit Warranty

                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>

                        </div>


                        {{-- Modal Body --}}
                        <div class="modal-body">

                            {{-- Warranty Years --}}
                            <div class="mb-3">

                                <label for="edit_warranty_years_{{ $warranty->id }}"
                                       class="form-label">

                                    Warranty Years
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="number"
                                       id="edit_warranty_years_{{ $warranty->id }}"
                                       name="warranty_years"
                                       class="form-control"
                                       min="1"
                                       step="1"
                                       value="{{ $warranty->warranty_years }}"
                                       required>

                            </div>


                            {{-- Price --}}
                            <div class="mb-3">

                                <label for="edit_price_{{ $warranty->id }}"
                                       class="form-label">

                                    Price
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="number"
                                       id="edit_price_{{ $warranty->id }}"
                                       name="price"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       value="{{ $warranty->price }}"
                                       required>

                            </div>

                        </div>


                        {{-- Modal Footer --}}
                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                Cancel

                            </button>

                            <button type="submit"
                                    class="btn btn-primary">

                                Save Changes

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endforeach

@endif

@endsection