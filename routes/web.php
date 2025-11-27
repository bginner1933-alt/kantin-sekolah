<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

// Autentikasi
Auth::routes();

// Halaman Home setelah login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rute dengan middleware auth (hanya bisa diakses pengguna yang sudah login)
Route::middleware(['auth'])->group(function(){
    // Rute untuk kategori
    Route::resource('kategori', KategoriController::class);

    // Rute untuk produk
    Route::resource('produk', ProdukController::class);

    // Rute untuk transaksi
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/search', [App\Http\Controllers\TransaksiController::class, 'search'])->name('transaksi.search');

    // Rute untuk pembayaran
    Route::resource('pembayaran', PembayaranController::class);
});

// Rute untuk tampilan template dashboard (ini hanya contoh, kamu bisa menghapus jika tidak diperlukan)
Route::get('tempelate', function() {
    return view('layouts.dashboard');
});
