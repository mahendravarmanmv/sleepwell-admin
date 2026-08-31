<?php
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
			
		Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
		->except(['destroy'])
		->names('categories');

		Route::delete(
		'categories/{category}',
		[\App\Http\Controllers\Admin\CategoryController::class, 'destroy']
		)->name('categories.destroy');
		
		Route::resource('dealers', DealerController::class)
		->names('dealers');
		
		Route::resource('products', ProductController::class)
		->names('products');
		
    });
});