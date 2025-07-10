<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BproductController;
use App\Http\Controllers\Backend\BcategoryController;
use App\Http\Controllers\Backend\BorderController;
use App\Http\Controllers\Backend\BuserController;
use App\Http\Controllers\Backend\BserviceController;
use App\Http\Controllers\Backend\BsettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController; // Ensure this is imported
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products Page Route - Now correctly uses query parameters for filtering
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Services Page Route
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login-attempt', [LoginController::class, 'authenticate'])->name('login.attempt');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register-attempt', [RegisterController::class, 'store'])->name('register.store');

// Logout route (POST request)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// User Profile Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route for displaying the profile edit form
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Checkout Route
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

    // Route to fetch single order details via AJAX (if still needed, otherwise remove)
    Route::get('/profile/orders/{order}', [OrderController::class, 'getOrderDetails'])->name('profile.order.details');
});

// Cart Routes (some need auth, cart.count is public)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCartItemCount'])->name('cart.count');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear'); // <--- NEW: Clear Cart Route


//------------------BACKEND---------------------

// Group backend routes under the 'admin' prefix
// IMPORTANT: Added 'can:admin-access' middleware for authorization
Route::prefix('admin')->middleware(['auth', 'can:admin-access'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', BproductController::class)->names([
        'index' => 'admin.products.index', 'create' => 'admin.products.create', 'store' => 'admin.products.store',
        'show' => 'admin.products.show', 'edit' => 'admin.products.edit', 'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('categories', BcategoryController::class)->names([
        'index' => 'admin.categories.index', 'create' => 'admin.categories.create', 'store' => 'admin.categories.store',
        'show' => 'admin.categories.show', 'edit' => 'admin.categories.edit', 'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('orders', BorderController::class)->names([
        'index' => 'admin.orders.index', 'create' => 'admin.orders.create', 'store' => 'admin.orders.store',
        'show' => 'admin.orders.show', 'edit' => 'admin.orders.edit', 'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy',
    ]);
    Route::resource('users', BuserController::class)->names([
        'index' => 'admin.users.index', 'create' => 'admin.users.create', 'store' => 'admin.users.store',
        'show' => 'admin.users.show', 'edit' => 'admin.users.edit', 'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::resource('services', BserviceController::class)->names([
        'index' => 'admin.services.index', 'create' => 'admin.services.create', 'store' => 'admin.services.store',
        'show' => 'admin.services.show', 'edit' => 'admin.services.edit', 'update' => 'admin.services.update',
        'destroy' => 'admin.services.destroy',
    ]);

    // Settings Management Routes
    Route::resource('settings', BsettingController::class)->names([
        'index' => 'admin.settings.index',
        'create' => 'admin.settings.create',
        'store' => 'admin.settings.store',
        'show' => 'admin.settings.show',
        'edit' => 'admin.settings.edit',
        'update' => 'admin.settings.update',
        'destroy' => 'admin.settings.destroy',
    ]);
});
