<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Authentication Routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Frontend Routes (public)
Route::prefix('generics')->name('generics.')->group(function () {
    Route::get('/', [App\Http\Controllers\Frontend\GenericController::class, 'index'])->name('index');
    Route::get('/compare', [App\Http\Controllers\Frontend\GenericController::class, 'compare'])->name('compare');
    Route::get('/{generic:slug}', [App\Http\Controllers\Frontend\GenericController::class, 'show'])->name('show');
});

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'admin'])->name('dashboard');

        Route::resource('roles', RoleController::class);

        Route::resource('users', UserController::class);

        // Product Management
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::post('products/{product}/update-stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::post('products/bulk-action', [App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])->name('products.bulk-action');

        // Category Management
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::get('api/categories', [App\Http\Controllers\Admin\CategoryController::class, 'getCategories'])->name('categories.api');
        Route::post('categories/reorder', [App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');

        // Generic Management
        Route::resource('generics', App\Http\Controllers\Admin\GenericController::class);

        // Supplier Management
        Route::resource('suppliers', App\Http\Controllers\Admin\SupplierController::class);
        Route::patch('suppliers/{supplier}/toggle-status', [App\Http\Controllers\Admin\SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
        Route::get('api/suppliers', [App\Http\Controllers\Admin\SupplierController::class, 'api'])->name('suppliers.api');

        // Stock Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('stock', [App\Http\Controllers\Admin\StockReportController::class, 'index'])->name('stock.index');
            Route::get('stock/low-stock', [App\Http\Controllers\Admin\StockReportController::class, 'lowStock'])->name('stock.low-stock');
            Route::get('stock/expired', [App\Http\Controllers\Admin\StockReportController::class, 'expired'])->name('stock.expired');
            Route::get('stock/valuation', [App\Http\Controllers\Admin\StockReportController::class, 'valuation'])->name('stock.valuation');
            Route::get('stock/movement', [App\Http\Controllers\Admin\StockReportController::class, 'movement'])->name('stock.movement');
            Route::get('stock/analysis', [App\Http\Controllers\Admin\StockReportController::class, 'analysis'])->name('stock.analysis');

            // Export Routes
            Route::get('stock/export/low-stock', [App\Http\Controllers\Admin\StockReportController::class, 'exportLowStock'])->name('stock.export.low-stock');
            Route::get('stock/export/expired', [App\Http\Controllers\Admin\StockReportController::class, 'exportExpired'])->name('stock.export.expired');
            Route::get('stock/export/valuation', [App\Http\Controllers\Admin\StockReportController::class, 'exportValuation'])->name('stock.export.valuation');
        });

        // Cloudinary Setup
        Route::get('cloudinary-setup', function () {
            return view('admin.cloudinary-setup');
        })->name('cloudinary.setup');
    });

    // Role management routes (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // User management routes (Admin and Manager)
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('users', UserController::class);
    });
});
