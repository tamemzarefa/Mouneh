<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\CategoryController as FrontCategoryController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\Frontend\BrandController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::middleware('auth')->patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::middleware('auth')->delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::middleware('auth')->post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::middleware('auth')->get('/account', [AccountController::class, 'index'])->name('account.index');
Route::middleware('auth')->get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
Route::middleware('auth')->get('/orders', [AccountController::class, 'orders'])->name('orders.index');
Route::middleware('auth')->get('/orders/{order}', [AccountController::class, 'showOrder'])->name('orders.show');
Route::middleware('auth')->get('/seller-dashboard', [AccountController::class, 'sellerDashboard'])->name('seller.dashboard');
// Notifications
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::middleware('auth')->post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
Route::middleware('auth')->post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
Route::middleware('auth')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/{address}/default', [AddressController::class, 'makeDefault'])->name('addresses.default');

    // Frontend product listing creation (seller flow)
    Route::get('/products/create', [FrontProductController::class, 'create'])->name('products.create');
    Route::post('/products', [FrontProductController::class, 'store'])->name('products.store');
});

// Categories
Route::get('/categories', [FrontCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontCategoryController::class, 'show'])->name('categories.show');

// Brands (public storefront)
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
// Brand/Company registration landing (must be before /brands/{brand})
Route::view('/brands/register', 'frontend.brands.register')->name('brands.register');
Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

// Seller: Request a brand (auth required)
Route::middleware('auth')->group(function(){
    Route::get('/brand/register', [\App\Http\Controllers\Frontend\BrandRequestController::class, 'create'])->name('brand.request.create');
    Route::post('/brand/register', [\App\Http\Controllers\Frontend\BrandRequestController::class, 'store'])->name('brand.request.store');
});

// Public product view
Route::get('/products/{product}', [FrontProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin login routes
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'store']);
    Route::post('logout', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'destroy'])->name('logout');
});

// Admin dashboard
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products CRUD
    Route::delete('products/bulk-destroy', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::post('products/bulk-approve', [ProductController::class, 'bulkApprove'])->name('products.bulk-approve');
    Route::resource('products', ProductController::class);
    // Approval endpoints
    Route::post('products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');

    // Users CRUD
    Route::delete('users/bulk-destroy', [AdminUserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
    Route::resource('users', AdminUserController::class);
    
    // Admins CRUD
    Route::resource('admins', AdminController::class);

    // Categories CRUD
    Route::delete('categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::resource('categories', CategoryController::class);

    // Brands CRUD (admin)
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::post('brands/{brand}/approve', [\App\Http\Controllers\Admin\BrandController::class, 'approve'])->name('brands.approve');
    Route::post('brands/{brand}/reject', [\App\Http\Controllers\Admin\BrandController::class, 'reject'])->name('brands.reject');

    // Orders (index/show)
    Route::resource('orders', OrderController::class)->only(['index','show']);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('orders.payment');

    // Money Transactions
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::view('invoices', 'admin.invoices.index')->name('invoices.index');
});

require __DIR__.'/auth.php';
