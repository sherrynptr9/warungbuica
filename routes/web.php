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

// ========================================================================
// 1. RUTE CUSTOMER & KATALOG (HOME)
// ========================================================================

// Halaman Depan (Katalog) - Tujuan redirect setelah login
Route::get('/', [ProductController::class, 'index'])->name('home');

// Keranjang & Transaksi
Route::get('/cart', [FrontendTransactionController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [FrontendTransactionController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/decrease/{id}', [FrontendTransactionController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::get('/cart/remove/{id}', [FrontendTransactionController::class, 'removeFromCart'])->name('cart.remove');

// Checkout
Route::get('/checkout', [FrontendTransactionController::class, 'checkoutPage'])->name('checkout.index');
Route::post('/checkout', [FrontendTransactionController::class, 'checkout'])->name('checkout');

// Redirect Login default (misal user ketik /login manual)
// Gunakan Route::redirect agar tidak pakai Closure
Route::redirect('/login', '/admin/login')->name('login');


// ========================================================================
// 2. RUTE KHUSUS KASIR
// ========================================================================

// A. Belum Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/kasir/login', [KasirLoginController::class, 'index'])->name('kasir.login');
    Route::post('/kasir/login', [KasirLoginController::class, 'authenticate'])->name('kasir.authenticate');
});

// B. Sudah Login (Auth)
Route::middleware('auth')->group(function () {
    Route::post('/kasir/logout', [KasirLoginController::class, 'logout'])->name('kasir.logout');

    // Tambahkan ini di web.php (di dalam middleware auth)
Route::get('/kasir/dashboard', function() {
    return redirect()->route('home'); // Balikin lagi ke home aja
})->name('kasir.dashboard');
    
    // Saya HAPUS route '/kasir/dashboard' karena kamu redirect ke 'home'
    // Ini juga menghilangkan penyebab error "Closure" tadi.
});