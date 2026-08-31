@extends('admin.layouts.app')

@section('title', 'Edit Dealer')

@section('page_heading', 'Edit Dealer')

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
        Edit
    </li>

@endsection

@section('content')

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Edit Dealer
        </h1>

        <p class="text-muted mb-0">
            Update {{ $dealer->dealer_name }}.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.dealers.update', $dealer) }}"
    >

        @csrf
        @method('PUT')

        @php
            $submitLabel = 'Update Dealer';
        @endphp

        @include('admin.dealers._form')

    </form>

@endsection