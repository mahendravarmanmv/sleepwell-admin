@extends('admin.layouts.app')

@section('title', 'Create Dealer')

@section('page_heading', 'Create Dealer')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a
            href="{{ route('admin.dealers.index') }}"
            class="text-decoration-none"
        >
            Dealers
        </a>
    </li>

    <li class="breadcrumb-item active">
        Create
    </li>

@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Create Dealer
        </h1>

        <p class="text-muted mb-0">
            Add a new SleepWell dealer.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.dealers.store') }}"
    >

        @csrf

        @php
            $submitLabel = 'Create Dealer';
        @endphp

        @include('admin.dealers._form')

    </form>

@endsection