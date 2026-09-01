<aside class="admin-sidebar admin-sidebar-desktop bg-dark text-white d-flex flex-column">

    <div class="admin-brand px-4 d-flex align-items-center border-bottom border-secondary">

        <a
            href="{{ route('admin.dashboard') }}"
            class="text-white text-decoration-none"
        >
            <div class="fw-bold fs-4">
                SleepWell
            </div>

            <div class="small text-white-50">
                Administration
            </div>
        </a>

    </div>


    <div class="flex-grow-1 p-3 overflow-auto">

        <div class="text-uppercase small text-white-50 fw-semibold mb-2 px-2">
            Main
        </div>

        <nav class="nav flex-column gap-1">

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            Catalog
        </div>

        <nav class="nav flex-column gap-1">

			<a
			href="{{ route('admin.categories.index') }}"
			class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
			>
			<i class="bi bi-grid me-2"></i>
			Categories
			</a>

			<a
			href="{{ route('admin.products.index') }}"
			class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
			>
			<i class="bi bi-box-seam me-2"></i>
			Products
			</a>

			<a
			href="{{ route('admin.dealers.index') }}"
			class="nav-link {{ request()->routeIs('admin.dealers.*') ? 'active' : '' }}"
			>
			<i class="bi bi-shop me-2"></i>
			Dealers
			</a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            Sales
        </div>

        <nav class="nav flex-column gap-1">

            <a
                href="#"
                class="nav-link"
            >
                <i class="bi bi-cart3 me-2"></i>
                Orders
            </a>

            <a
                href="#"
                class="nav-link"
            >
                <i class="bi bi-people me-2"></i>
                Customers
            </a>

        </nav>


        <div class="text-uppercase small text-white-50 fw-semibold mt-4 mb-2 px-2">
            System
        </div>

        <nav class="nav flex-column gap-1">

            <a
                href="#"
                class="nav-link"
            >
                <i class="bi bi-bar-chart me-2"></i>
                Reports
            </a>

            <a
                href="#"
                class="nav-link"
            >
                <i class="bi bi-gear me-2"></i>
                Settings
            </a>

        </nav>

    </div>


    <div class="p-3 border-top border-secondary">

        <div class="small text-white-50">
            SleepWell Admin
        </div>

        <div class="small text-white-50">
            Version 1.0
        </div>

    </div>

</aside>