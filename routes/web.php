<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\produk\ProdukHandphoneController;
use App\Http\Controllers\produk\ProdukViewsController;
use App\Http\Controllers\ProdukController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function() {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // produk
    Route::prefix('/produk')->group(function() {
        Route::get('/', [ProdukViewsController::class, 'index'])->name('produk');
        Route::prefix(('/handphone'))->group(function() {
            Route::get('/', [ProdukHandphoneController::class, 'index'])->name('handphone');
            Route::post('/store', [ProdukHandphoneController::class, 'store'])->name('store');
        });
        Route::get('/pulsa', [ProdukViewsController::class, 'pulsa'])->name('pulsa');
        Route::get('/aksesoris', [ProdukViewsController::class, 'aksesoris'])->name('aksesoris');
        Route::get('/servis', [ProdukViewsController::class, 'servis'])->name('servis');
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
