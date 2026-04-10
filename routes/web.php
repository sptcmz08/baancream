<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CreditController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SiteSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\StoreController::class, 'index'])->name('home');
Route::get('/media/{path}', [MediaController::class, 'show'])->where('path', '.*')->name('media.show');
Route::get('/products/{product}', [\App\Http\Controllers\StoreController::class, 'show'])->name('products.show');
Route::get('/search', [\App\Http\Controllers\StoreController::class, 'search'])->name('store.search');
Route::get('/branding/logo', [SiteSettingController::class, 'showStorefrontLogo'])->name('branding.logo');
Route::post('/cart/add', [\App\Http\Controllers\StoreController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [\App\Http\Controllers\StoreController::class, 'cart'])->name('cart.index');
Route::post('/cart/remove', [\App\Http\Controllers\StoreController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [\App\Http\Controllers\StoreController::class, 'checkout'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [\App\Http\Controllers\StoreController::class, 'processCheckout'])->name('checkout.process')->middleware('auth');

Route::get('/dashboard', function () {
    $user = request()->user();

    if ($user?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Account pages
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::get('/account/orders', [\App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{order}', [\App\Http\Controllers\AccountController::class, 'orderDetail'])->name('account.order');
    Route::get('/account/notifications', [\App\Http\Controllers\AccountController::class, 'notifications'])->name('account.notifications');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('credits', CreditController::class);
    Route::resource('orders', OrderController::class);
    Route::get('settings/branding', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings/branding', [SiteSettingController::class, 'update'])->name('settings.update');
});
