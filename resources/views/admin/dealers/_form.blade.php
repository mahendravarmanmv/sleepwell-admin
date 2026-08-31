<div class="row g-4">

    <div class="col-lg-8">

        <div class="card admin-card">

            <div class="card-body">

                <div class="mb-3">

                    <label
                        for="dealer_name"
                        class="form-label fw-semibold"
                    >
                        Dealer Name
                    </label>

                    <input
                        type="text"
                        name="dealer_name"
                        id="dealer_name"
                        class="form-control @error('dealer_name') is-invalid @enderror"
                        value="{{ old('dealer_name', $dealer->dealer_name ?? '') }}"
                        maxlength="255"
                        required
                    >

                    @error('dealer_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="city"
                        class="form-label fw-semibold"
                    >
                        City
                    </label>

                    <input
                        type="text"
                        name="city"
                        id="city"
                        class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city', $dealer->city ?? '') }}"
                        maxlength="255"
                    >

                    <div class="form-text">
                        Dealer's city for display/information purposes.
                    </div>

                    @error('city')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-check form-switch">

                    <input
                        type="hidden"
                        name="is_verified"
                        value="0"
                    >

                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="is_verified"
                        name="is_verified"
                        value="1"
                        @checked(old(
                            'is_verified',
                            $dealer->is_verified ?? true
                        ))
                    >

                    <label
                        class="form-check-label fw-semibold"
                        for="is_verified"
                    >
                        Verified Dealer
                    </label>

                </div>

            </div>

        </div>

    </div>


    <div class="col-lg-4">

        <div class="card admin-card">

            <div class="card-body">

                <h6 class="fw-semibold">
                    Dealer Status
                </h6>

                <p class="small text-muted mb-0">
                    Verified dealers can be displayed as verified
                    dealers on the customer-facing website.
                </p>

            </div>

        </div>

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">

    <a
        href="{{ route('admin.dealers.index') }}"
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