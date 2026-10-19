<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;

/* Rute untuk Halaman Utama (Beranda/Home) */
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Storefront Shop Routes (Video 26 - 32)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

// Storefront Cart Routes (Video 33 - 37)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.remove');
Route::delete('/cart/empty', [CartController::class, 'empty_cart'])->name('cart.empty');
Route::post('/cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('/cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');

// Storefront Wishlist Routes (Video 38 - 41)
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove_item'])->name('wishlist.remove');
Route::delete('/wishlist/empty', [WishlistController::class, 'empty_wishlist'])->name('wishlist.empty');
Route::post('/wishlist/move-to-cart/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

require __DIR__.'/auth.php';

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account/dashboard', [UserController::class, 'index'])->name('user.index');
});

// Admin Routes
Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // Brands (Video 07 - 11)
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'brand_add'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update/{id}', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');

    // Categories (Video 12 - 16)
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    // Products (Video 17 - 25)
    Route::get('/admin/products', [ProductController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/export', [ProductController::class, 'product_export'])->name('admin.products.export');
    Route::get('/admin/product/add', [ProductController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [ProductController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [ProductController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'product_delete'])->name('admin.product.delete');
    Route::delete('/admin/products/bulk-delete', [ProductController::class, 'product_bulk_delete'])->name('admin.products.bulk.delete');

    // Coupons (Video 42 - 45)
    Route::get('/admin/coupons', [CouponController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupon/add', [CouponController::class, 'coupon_add'])->name('admin.coupon.add');
    Route::post('/admin/coupon/store', [CouponController::class, 'coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/edit/{id}', [CouponController::class, 'coupon_edit'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update/{id}', [CouponController::class, 'coupon_update'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/delete/{id}', [CouponController::class, 'coupon_delete'])->name('admin.coupon.delete');
});
