@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Product Dealers</h1>

            <p class="text-muted mb-0">
                Manage dealers for
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
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- ASSIGN DEALER --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Assign Dealer
            </h5>
        </div>

        <div class="card-body">

            @if($dealers->count())

                <form method="POST"
                      action="{{ route('admin.products.dealers.store', $product) }}">

                    @csrf

                    <div class="row">

                        {{-- Dealer --}}
                        <div class="col-md-5 mb-3">

                            <label class="form-label">
                                Dealer <span class="text-danger">*</span>
                            </label>

                            <select name="dealer_id"
                                    class="form-control"
                                    required>

                                <option value="">
                                    Select Dealer
                                </option>

                                @foreach($dealers as $dealer)

                                    @if(!in_array($dealer->id, $assignedDealerIds))

                                        <option value="{{ $dealer->id }}"
                                            {{ old('dealer_id') == $dealer->id ? 'selected' : '' }}>

                                            {{ $dealer->dealer_name }}

                                            @if($dealer->city)
                                                — {{ $dealer->city }}
                                            @endif

                                        </option>

                                    @endif

                                @endforeach

                            </select>

                        </div>


                        {{-- Dealer Price --}}
                        <div class="col-md-5 mb-3">

                            <label class="form-label">
                                Dealer Price
                                <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   min="0"
                                   step="0.01"
                                   value="{{ old('price') }}"
                                   required>

                            <small class="form-text text-muted">
                                Price applicable to this product for this dealer.
                            </small>

                        </div>


                        {{-- Submit --}}
                        <div class="col-md-2 mb-3 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-primary w-100">
                                Assign Dealer
                            </button>

                        </div>

                    </div>

                </form>

            @else

                <div class="alert alert-warning mb-0">
                    No dealers are available.
                    Please create a dealer first.
                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ASSIGNED DEALERS --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Assigned Dealers
            </h5>

            <span class="badge badge-primary">
                {{ $product->dealers->count() }}
            </span>

        </div>


        <div class="card-body p-0">

            @if($product->dealers->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="8%">ID</th>
                                <th>Dealer</th>
                                <th>City</th>
                                <th>Verification</th>
                                <th>Dealer Price</th>
                                <th width="220">Actions</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($product->dealers as $dealer)

                                <tr>

                                    {{-- ID --}}
                                    <td>
                                        {{ $dealer->id }}
                                    </td>


                                    {{-- Dealer --}}
                                    <td>
                                        <strong>
                                            {{ $dealer->dealer_name }}
                                        </strong>
                                    </td>


                                    {{-- City --}}
                                    <td>
                                        {{ $dealer->city ?: '—' }}
                                    </td>


                                    {{-- Verification --}}
                                    <td>

                                        @if($dealer->is_verified)

                                            <span class="badge badge-success">
                                                Verified
                                            </span>

                                        @else

                                            <span class="badge badge-secondary">
                                                Unverified
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Dealer Price --}}
                                    <td>

                                        <strong>
                                            ₹{{ number_format((float) $dealer->pivot->price, 2) }}
                                        </strong>

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        {{-- Edit Price --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editDealerModal{{ $dealer->id }}">

                                            Edit Price

                                        </button>


                                        {{-- Remove Dealer --}}
                                        <form method="POST"
                                              action="{{ route('admin.products.dealers.destroy', [$product, $dealer]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to remove this dealer from the product?');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">

                                                Remove

                                            </button>

                                        </form>

                                    </td>

                                </tr>


                                {{-- ================================================= --}}
                                {{-- EDIT DEALER PRICE MODAL --}}
                                {{-- ================================================= --}}

                                <div class="modal fade"
                                     id="editDealerModal{{ $dealer->id }}"
                                     tabindex="-1"
                                     aria-labelledby="editDealerModalLabel{{ $dealer->id }}"
                                     aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">


                                            {{-- Modal Header --}}
                                            <div class="modal-header">

                                                <h5 class="modal-title"
                                                    id="editDealerModalLabel{{ $dealer->id }}">

                                                    Edit Dealer Price

                                                </h5>

                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                </button>

                                            </div>


                                            {{-- Modal Form --}}
                                            <form method="POST"
                                                  action="{{ route('admin.products.dealers.update', [$product, $dealer]) }}">

                                                @csrf

                                                @method('PUT')


                                                {{-- Modal Body --}}
                                                <div class="modal-body">

                                                    {{-- Dealer --}}
                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Dealer
                                                        </label>

                                                        <input type="text"
                                                               class="form-control"
                                                               value="{{ $dealer->dealer_name }}"
                                                               readonly>

                                                    </div>


                                                    {{-- City --}}
                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            City
                                                        </label>

                                                        <input type="text"
                                                               class="form-control"
                                                               value="{{ $dealer->city ?: '—' }}"
                                                               readonly>

                                                    </div>


                                                    {{-- Dealer Price --}}
                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Dealer Price
                                                            <span class="text-danger">*</span>
                                                        </label>

                                                        <input type="number"
                                                               name="price"
                                                               class="form-control"
                                                               min="0"
                                                               step="0.01"
                                                               value="{{ $dealer->pivot->price }}"
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

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4 text-center text-muted">

                    <div class="mb-2">
                        No dealers have been assigned to this product yet.
                    </div>

                    <small>
                        Use the "Assign Dealer" form above to add a dealer.
                    </small>

                </div>

            @endif

        </div>

    </div>

</div>
@endsection