@if (session('success'))
    <div class="container-fluid px-4 pt-3">

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    </div>
@endif


@if (session('error'))
    <div class="container-fluid px-4 pt-3">

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    </div>
@endif


@if ($errors->any())
    <div class="container-fluid px-4 pt-3">

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    </div>
@endif