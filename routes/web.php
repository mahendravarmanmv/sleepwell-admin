<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest')->group(function () {

        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.submit');

    });


    /*
    |--------------------------------------------------------------------------
    | Authenticated Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class)
            ->except(['destroy'])
            ->names('categories');

        Route::delete(
            'categories/{category}',
            [CategoryController::class, 'destroy']
        )->name('categories.destroy');


        /*
        |--------------------------------------------------------------------------
        | Dealers
        |--------------------------------------------------------------------------
        */

        Route::resource('dealers', DealerController::class)
            ->names('dealers');


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class)
            ->names('products');


        /*
        |--------------------------------------------------------------------------
        | Product Gallery
        |--------------------------------------------------------------------------
        */

        Route::prefix('products/{product}')
            ->name('products.')
            ->group(function () {

                Route::get(
                    'gallery',
                    [ProductGalleryController::class, 'index']
                )->name('gallery.index');

                Route::post(
                    'gallery',
                    [ProductGalleryController::class, 'store']
                )->name('gallery.store');

                Route::put(
                    'gallery/{image}',
                    [ProductGalleryController::class, 'update']
                )->name('gallery.update');

                Route::delete(
                    'gallery/{image}',
                    [ProductGalleryController::class, 'destroy']
                )->name('gallery.destroy');

            });

    });

});