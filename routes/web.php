<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\PostController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

// Route untuk Posts
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts'); // Menampilkan daftar post
    Route::post('/posts/{id}/reduce-stock', [PostController::class, 'reduceStock'])->name('posts.reduceStock'); // Mengurangi stok
});

// Pengaturan
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Volt Settings Routes
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Admin Routes
    Route::get('/admin', [AdminController::class, 'index'])->name('dash-admin');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Seller Routes
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/manage-posts', [SellerController::class, 'index'])->name('index'); // Menampilkan semua post
        Route::post('/create-post', [SellerController::class, 'create'])->name('create'); // Form untuk membuat post
    });
});

// Authentication Routes
require __DIR__ . '/auth.php';
