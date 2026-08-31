<header class="admin-header bg-white border-bottom">

    <div class="container-fluid px-3 px-md-4 h-100">

        <div class="d-flex justify-content-between align-items-center h-100">

            <div class="d-flex align-items-center gap-3">

                <button
                    class="btn btn-outline-secondary d-lg-none"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#adminMobileSidebar"
                    aria-controls="adminMobileSidebar"
                    aria-label="Open navigation"
                >
                    <i class="bi bi-list fs-5"></i>
                </button>


                <div>

                    <h5 class="mb-0 fw-semibold">
                        @yield('page_heading', 'Dashboard')
                    </h5>

                </div>

            </div>


            <div class="dropdown">

                <button
                    class="btn btn-light d-flex align-items-center gap-2 border-0"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >

                    <span
                        class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-semibold"
                        style="width: 38px; height: 38px;"
                    >
                        {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                    </span>

                    <span class="d-none d-md-inline text-start">

                        <span class="d-block fw-semibold small">
                            {{ auth('admin')->user()->name }}
                        </span>

                        <span class="d-block text-muted" style="font-size: 0.75rem;">
                            Administrator
                        </span>

                    </span>

                    <i class="bi bi-chevron-down small"></i>

                </button>


                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                    <li>
                        <span class="dropdown-item-text">

                            <span class="d-block fw-semibold">
                                {{ auth('admin')->user()->name }}
                            </span>

                            <span class="d-block small text-muted">
                                {{ auth('admin')->user()->email }}
                            </span>

                        </span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form
                            method="POST"
                            action="{{ route('admin.logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item text-danger"
                            >
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</header>