<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendTransactionController;
use App\Http\Controllers\Auth\KasirLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Home / Katalog
    Route::get('/', [ProductController::class, 'index'])->name('home');

    // Cart Routes
    Route::get('/cart', [FrontendTransactionController::class, 'index'])->name('cart.index');
    
    // --- PERBAIKAN DISINI ---
    // Ubah dari 'post' menjadi 'get'
    Route::post('/cart/add/{id}', [FrontendTransactionController::class, 'addToCart'])->name('cart.add');
    // ------------------------

    Route::get('/cart/decrease/{id}', [FrontendTransactionController::class, 'decreaseQuantity'])->name('cart.decrease');
    Route::get('/cart/remove/{id}', [FrontendTransactionController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [FrontendTransactionController::class, 'checkoutPage'])->name('checkout.index'); // Halaman Checkout
    Route::post('/checkout', [FrontendTransactionController::class, 'checkout'])->name('checkout'); // Proses Submit (Tetap POST)
});

// Redirect /login → /kasir/login
Route::redirect('/login', '/kasir/login')->name('login');

// ... (Sisa kode ke bawah biarkan saja)
Route::middleware('guest')->group(function () {
    Route::get('/kasir/login', [KasirLoginController::class, 'index'])->name('kasir.login');
    Route::post('/kasir/login', [KasirLoginController::class, 'authenticate'])->name('kasir.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/kasir/logout', [KasirLoginController::class, 'logout'])->name('kasir.logout');
    Route::get('/kasir/dashboard', function () {
        return redirect()->route('home');
    })->name('kasir.dashboard');
});