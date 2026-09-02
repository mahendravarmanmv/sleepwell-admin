<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductPackageController;
use App\Http\Controllers\Admin\ProductWarrantyController;
use App\Http\Controllers\Admin\ProductDealerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderPaymentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest:admin')->group(function () {

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
            ->names('categories');


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
        | Product Components
        |--------------------------------------------------------------------------
        */

        Route::prefix('products/{product}')
            ->name('products.')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | Product Gallery
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Product Packages
                |--------------------------------------------------------------------------
                */

                Route::get(
                    'packages',
                    [ProductPackageController::class, 'index']
                )->name('packages.index');

                Route::post(
                    'packages',
                    [ProductPackageController::class, 'store']
                )->name('packages.store');

                Route::put(
                    'packages/{package}',
                    [ProductPackageController::class, 'update']
                )->name('packages.update');

                Route::delete(
                    'packages/{package}',
                    [ProductPackageController::class, 'destroy']
                )->name('packages.destroy');


                /*
                |--------------------------------------------------------------------------
                | Product Warranties
                |--------------------------------------------------------------------------
                */

                Route::get(
                    'warranties',
                    [ProductWarrantyController::class, 'index']
                )->name('warranties.index');

                Route::post(
                    'warranties',
                    [ProductWarrantyController::class, 'store']
                )->name('warranties.store');

                Route::put(
                    'warranties/{warranty}',
                    [ProductWarrantyController::class, 'update']
                )->name('warranties.update');

                Route::delete(
                    'warranties/{warranty}',
                    [ProductWarrantyController::class, 'destroy']
                )->name('warranties.destroy');


                /*
                |--------------------------------------------------------------------------
                | Product Dealers
                |--------------------------------------------------------------------------
                */

                Route::get(
                    'dealers',
                    [ProductDealerController::class, 'index']
                )->name('dealers.index');

                Route::post(
                    'dealers',
                    [ProductDealerController::class, 'store']
                )->name('dealers.store');

                Route::put(
                    'dealers/{dealer}',
                    [ProductDealerController::class, 'update']
                )->name('dealers.update');

                Route::delete(
                    'dealers/{dealer}',
                    [ProductDealerController::class, 'destroy']
                )->name('dealers.destroy');

            });


        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        Route::get(
            'customers',
            [CustomerController::class, 'index']
        )->name('customers.index');

        Route::get(
            'customers/{customer}',
            [CustomerController::class, 'show']
        )->name('customers.show');


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::get(
            'orders',
            [OrderController::class, 'index']
        )->name('orders.index');

        Route::get(
            'orders/{order}',
            [OrderController::class, 'show']
        )->name('orders.show');

        Route::put(
            'orders/{order}/status',
            [OrderController::class, 'updateStatus']
        )->name('orders.status.update');

        Route::put(
            'orders/{order}/payment',
            [OrderPaymentController::class, 'update']
        )->name('orders.payment.update');


        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        Route::get(
            'payments',
            [PaymentController::class, 'index']
        )->name('payments.index');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get(
            'notifications',
            [NotificationController::class, 'index']
        )->name('notifications.index');


        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            'reports',
            [ReportController::class, 'index']
        )->name('reports.index');

    });

});