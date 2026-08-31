<div class="container-fluid px-4 pt-4">

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb mb-3">

            <li class="breadcrumb-item">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-decoration-none"
                >
                    Dashboard
                </a>
            </li>

            @yield('breadcrumb')

        </ol>

    </nav>

</div>