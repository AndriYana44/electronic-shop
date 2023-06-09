<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\produk\AksesorisController;
use App\Http\Controllers\produk\ProdukAksesorisController;
use App\Http\Controllers\produk\ProdukHandphoneController;
use App\Http\Controllers\produk\ProdukPulsaController;
use App\Http\Controllers\produk\ProdukViewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth', 'verified'])->group(function() {
    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // cart
    Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/insert', [CartController::class, 'insert'])->name('cartInsert');
        Route::patch('/changeDataCart/{id}', [CartController::class, 'changeDataCart']);
        Route::delete('/deleteDataCart/{id}', [CartController::class, 'deleteDataCart']);
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cartCheckout');
    });
    // produk
    Route::prefix('/produk')->group(function() {
        Route::get('/', [ProdukViewsController::class, 'index'])->name('produk');
        Route::prefix(('/handphone'))->group(function() {
            Route::get('/', [ProdukHandphoneController::class, 'index'])->name('handphone');
            Route::post('/', [ProdukHandphoneController::class, 'index'])->name('handphone');
            Route::post('/store', [ProdukHandphoneController::class, 'store'])->name('store-handphone');
            Route::post('/checkout/{id}', [ProdukHandphoneController::class, 'checkout'])->name('checkout-handphone');
            Route::patch('/update/{id}', [ProdukHandphoneController::class, 'update'])->name('update-handphone');
            Route::delete('/delete/{id}', [ProdukHandphoneController::class, 'delete'])->name('delete-handphone');
        });
        Route::prefix('pulsa')->group(function() {
            Route::get('/', [ProdukPulsaController::class, 'index'])->name('pulsa');
            Route::post('/', [ProdukPulsaController::class, 'index'])->name('pulsa');
            Route::post('/store', [ProdukPulsaController::class, 'store'])->name('store-pulsa');
            Route::post('/store_saldo', [ProdukPulsaController::class, 'store_saldo'])->name('store_saldo');
            Route::post('/checkout', [ProdukPulsaController::class, 'checkout'])->name('checkout-pulsa');
        });
        Route::prefix('aksesoris')->group(function() {
            Route::get('/', [ProdukAksesorisController::class, 'index'])->name('aksesoris');
            Route::post('/store', [ProdukAksesorisController::class, 'store'])->name('store-aksesoris');
        });
        Route::get('/servis', [ProdukViewsController::class, 'servis'])->name('servis');
        Route::prefix('json')->group(function() {
            Route::get('/detail-handphone/{id}', [ProdukHandphoneController::class, 'getDetailHandphone'])->name('getDetailHandphone');
            Route::get('/varian-handphone/{id}', [ProdukHandphoneController::class, 'getVarianHandphone'])->name('getVarianHandphone');
            Route::get('/varian-aksesoris/{id}', [ProdukAksesorisController::class, 'getVarianAksesoris'])->name('getVarianAksesoris');
            Route::get('/detail-aksesoris/{id}', [ProdukAksesorisController::class, 'getDetailAksesoris'])->name('getDetailAksesoris');
        });
    });
    // gudang
    Route::prefix('gudang')->group(function() {
        Route::get('/', [GudangController::class, 'index'])->name('gudang');
    });
    // keuangan
    Route::prefix('/keuangan')->group(function() {
        Route::get('/', [KeuanganController::class, 'index'])->name('keuangan');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify')->middleware(['signed']);
    Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
});

require __DIR__.'/auth.php';
