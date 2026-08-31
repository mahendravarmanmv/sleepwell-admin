<div
    class="offcanvas offcanvas-start bg-dark text-white"
    tabindex="-1"
    id="adminMobileSidebar"
    aria-labelledby="adminMobileSidebarLabel"
>

    <div class="offcanvas-header border-bottom border-secondary">

        <div>

            <div
                class="fw-bold fs-5"
                id="adminMobileSidebarLabel"
            >
                SleepWell
            </div>

            <div class="small text-white-50">
                Administration
            </div>

        </div>

        <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    <div class="offcanvas-body p-3">

        <div class="text-uppercase small text-white-50 fw-semibold mb-2 px-2">
            Main
        </div>

        <nav class="nav flex-column gap-1">

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link text-white rounded {{ request()->routeIs('admin.dashboard') ? 'active bg-white bg-opacity-10' : '' }}"
            >
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            Catalog
        </div>

        <nav class="nav flex-column gap-1">

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-grid me-2"></i>
                Categories
            </a>

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-box-seam me-2"></i>
                Products
            </a>

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-shop me-2"></i>
                Dealers
            </a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            Sales
        </div>

        <nav class="nav flex-column gap-1">

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-cart3 me-2"></i>
                Orders
            </a>

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-people me-2"></i>
                Customers
            </a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            System
        </div>

        <nav class="nav flex-column gap-1">

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-bar-chart me-2"></i>
                Reports
            </a>

            <a href="#" class="nav-link text-white rounded">
                <i class="bi bi-gear me-2"></i>
                Settings
            </a>

        </nav>

    </div>

</div>