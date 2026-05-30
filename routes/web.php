<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/{id}', [ProductController::class, 'show'])
        ->name('products.show');

});

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

Route::prefix('categories')->group(function () {

    Route::get('/', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/{id}', [CategoryController::class, 'show'])
        ->name('categories.show');

});

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index'])
        ->name('cart');

    Route::post('/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::post('/update', [CartController::class, 'update'])
        ->name('cart.update');

    Route::post('/delete', [CartController::class, 'delete'])
        ->name('cart.delete');

});

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

Route::get('/search', [ProductController::class, 'search'])
    ->name('products.search');

Route::get('/search-live', [ProductController::class, 'liveSearch']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    Route::get('/payment', [CheckoutController::class, 'payment'])
        ->name('payment');

    Route::post('/stripe', [CheckoutController::class, 'stripe'])
        ->name('stripe');

    /*
    |--------------------------------------------------------------------------
    | User Orders
    |--------------------------------------------------------------------------
    */

    Route::get('/my-orders', [UserOrderController::class, 'index'])
        ->name('my.orders');

    /*
    |--------------------------------------------------------------------------
    | Wishlist
    |--------------------------------------------------------------------------
    */

    Route::prefix('wishlist')->group(function () {

        Route::get('/', [WishlistController::class, 'index'])
            ->name('wishlist');

        Route::get('/add/{id}', [WishlistController::class, 'add'])
            ->name('wishlist.add');

        Route::get('/remove/{id}', [WishlistController::class, 'remove'])
            ->name('wishlist.remove');

    });

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */

    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');

    /*
    |--------------------------------------------------------------------------
    | Coupons
    |--------------------------------------------------------------------------
    */

    Route::post('/coupon/apply', [CouponController::class, 'apply'])
        ->name('coupon.apply');

    Route::delete('/coupon/remove', [CouponController::class, 'remove'])
        ->name('coupon.remove');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Payment Success
|--------------------------------------------------------------------------
*/

Route::get('/payment/success/{order}', [CheckoutController::class, 'success'])
    ->name('payment.success');

/*
|--------------------------------------------------------------------------
| Order Success
|--------------------------------------------------------------------------
*/

Route::get('/order/success/{id}', function ($id) {

    $order = \App\Models\Order::with('items.product')
        ->findOrFail($id);

    return view(
        'frontend.orders.order-success',
        compact('order')
    );

})->name('order.success');

/*
|--------------------------------------------------------------------------
| Invoice
|--------------------------------------------------------------------------
*/

Route::get('/invoice/{order}', [OrderController::class, 'invoice'])
    ->name('invoice');

/*
|--------------------------------------------------------------------------
| Export Orders
|--------------------------------------------------------------------------
*/

Route::get('/orders/export', [OrderController::class, 'export'])
    ->name('orders.export');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.status');

    });

Route::view('/about', 'layouts.about')->name('about');

Route::view('/contact', 'layouts.contact')->name('contact');

require __DIR__ . '/auth.php';
