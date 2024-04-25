<?php

use App\Http\Controllers\DetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('layouts.dashboard', ["title" => "Dashboard"]);
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/asd', function () {
    return view('layouts.coba', ["title" => "Dashboard"]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/produk-tambah', [ProdukController::class, 'create']);
    Route::post('/produk-tambah', [ProdukController::class, 'store']);
    Route::get('/produk-hapus/{produk_id}', [ProdukController::class, 'destroy']);
    Route::get('/produk-edit/{produk_id}', [ProdukController::class, 'edit']);
    Route::post('/produk-edit/{produk_id}', [ProdukController::class, 'update']);

    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/pelanggan-detail/{pelanggan_id}', [PelangganController::class, 'show']);
    Route::get('/pelanggan-hapus/{pelanggan_id}', [PelangganController::class, 'destroy']);
    Route::get('/pelanggan-edit/{pelanggan_id}', [PelangganController::class, 'edit']);
    Route::post('/pelanggan-edit/{pelanggan_id}', [PelangganController::class, 'update']);

    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::get('/pembelian-lanjutan', [PembelianController::class, 'create']);
    Route::post('/proses', [PembelianController::class, 'store']);

    Route::get('/detail', [DetailController::class, 'index']);
    Route::get('/detail-pembelian/{produk_id}', [DetailController::class, 'show']);

});

require __DIR__ . '/auth.php';
