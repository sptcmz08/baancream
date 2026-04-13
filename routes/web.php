<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CreditController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
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
    Route::post('/account/credits/{credit}/slip', [\App\Http\Controllers\AccountController::class, 'uploadCreditSlip'])->name('account.credits.slip');
    Route::get('/account/notifications', [\App\Http\Controllers\AccountController::class, 'notifications'])->name('account.notifications');

    // Address Book API
    Route::get('/api/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/api/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/api/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/api/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/api/addresses/{address}/primary', [AddressController::class, 'setPrimary'])->name('addresses.primary');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::post('products/{product}/copy', [ProductController::class, 'copy'])->name('products.copy');
    Route::delete('products/bulk-destroy-selected', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::resource('products', ProductController::class);
    Route::resource('credits', CreditController::class);
    Route::post('orders/confirm-all-credit', [OrderController::class, 'confirmAllCredit'])->name('orders.confirm-all-credit');
    Route::post('orders/{order}/shipping-adjustment', [OrderController::class, 'addShippingAdjustment'])->name('orders.shipping-adjustment');
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/quick-action', [OrderController::class, 'quickAction'])->name('orders.quick-action');
    Route::resource('banners', BannerController::class)->except(['create', 'show', 'edit']);
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
    Route::get('settings/branding', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings/branding', [SiteSettingController::class, 'update'])->name('settings.update');
});
