<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/* Rute untuk Halaman Utama (Beranda/Home) */
Route::get('/', [HomeController::class, 'index'])->name('home.index');

require __DIR__.'/auth.php';

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account/dashboard', [UserController::class, 'index'])->name('user.index');
});

// Admin Routes
Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
