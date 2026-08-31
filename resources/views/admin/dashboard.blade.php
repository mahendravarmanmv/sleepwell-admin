@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page_heading', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        Dashboard
    </li>
@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Dashboard
        </h1>

        <p class="text-muted mb-0">
            Welcome back, {{ auth('admin')->user()->name }}.
        </p>

    </div>


    <div class="row g-4">

        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Products
                    </div>

                    <div class="fs-2 fw-bold mt-2">
                        —
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Categories
                    </div>

                    <div class="fs-2 fw-bold mt-2">
                        —
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Dealers
                    </div>

                    <div class="fs-2 fw-bold mt-2">
                        —
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Orders
                    </div>

                    <div class="fs-2 fw-bold mt-2">
                        —
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection