<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Dashboard') | SleepWell Admin
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>

<body>

    <div class="admin-wrapper d-flex">

        @include('admin.partials.sidebar')

        @include('admin.partials.mobile-sidebar')


        <div class="admin-main flex-grow-1 d-flex flex-column">

            @include('admin.partials.header')


            <main class="admin-page-content flex-grow-1">

                @include('admin.partials.breadcrumbs')

                @include('admin.partials.alerts')

                <div class="container-fluid px-3 px-md-4 pb-4">

                    @yield('content')

                </div>

            </main>


            @include('admin.partials.footer')

        </div>

    </div>


    @stack('scripts')

</body>

</html>