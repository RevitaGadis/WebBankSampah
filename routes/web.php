<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NasabahLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\SetoranController;

Route::middleware('guest:web')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth:web')
    ->name('logout');

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/setoran/cari-nasabah', [SetoranController::class, 'cariNasabah'])->name('setoran.cari-nasabah');
    Route::resource('setoran', SetoranController::class)->only(['index','create','store','show']);

    Route::resource('nasabah', NasabahController::class)->only(['index','show','store','update','destroy']);

    Route::middleware('role:admin')->group(function () {
        Route::resource('jenis-sampah', JenisSampahController::class)->only(['index','store','update','destroy']);
    });
});

Route::prefix('portal')->group(function () {
    Route::middleware('guest:nasabah')->group(function () {
        Route::get('/login', [NasabahLoginController::class, 'create'])->name('nasabah.login');
        Route::post('/login', [NasabahLoginController::class, 'store']);
    });
    Route::middleware('auth:nasabah')->group(function () {
        Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('portal.dashboard');
        Route::post('/logout', [NasabahLoginController::class, 'destroy'])->name('nasabah.logout');
    });
});