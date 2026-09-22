<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\SetoranController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Login 
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Area Nasabah 
|--------------------------------------------------------------------------
*/
Route::prefix('nasabah')->name('nasabah.')->middleware('auth:nasabah')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat-setoran', [PortalController::class, 'riwayat'])->name('riwayat');
    Route::get('/saldo-tabungan', [PortalController::class, 'saldo'])->name('saldo');
    Route::get('/profil', [PortalController::class, 'profil'])->name('profil');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Area Petugas 
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->name('petugas.')->middleware('auth:web')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/setoran', [PetugasController::class, 'setoran'])->name('setoran');
    Route::get('/nasabah', [PetugasController::class, 'nasabah'])->name('nasabah');
    Route::get('/jenis-sampah', [PetugasController::class, 'jenisSampah'])->name('jenis-sampah');
    Route::get('/riwayat', [PetugasController::class, 'riwayat'])->name('riwayat');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/setoran/cari-nasabah', [SetoranController::class, 'cariNasabah'])->name('setoran.cari-nasabah');

    Route::post('/setoran/simpan', [SetoranController::class, 'store'])->name('setoran.store');
    Route::post('/nasabah/simpan', [NasabahController::class, 'store'])->name('nasabah.store');
    Route::put('/nasabah/{nasabah}', [NasabahController::class, 'update'])->name('nasabah.update');
    Route::delete('/nasabah/{nasabah}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');
});

/*
|--------------------------------------------------------------------------
| Area Admin 
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/nasabah', [AdminController::class, 'nasabah'])->name('nasabah');
    Route::get('/nasabah/rekap/{nasabah:no_nasabah}', [AdminController::class, 'rekapNasabah'])->name('nasabah.rekap');
    Route::get('/jenis-sampah', [AdminController::class, 'jenisSampah'])->name('jenis-sampah');
    Route::get('/akun', [AdminController::class, 'akun'])->name('akun');
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::post('/jenis-sampah/simpan', [JenisSampahController::class, 'store'])->name('jenis-sampah.store');
    Route::put('/jenis-sampah/{jenis_sampah}', [JenisSampahController::class, 'update'])->name('jenis-sampah.update');
    Route::delete('/jenis-sampah/{jenis_sampah}', [JenisSampahController::class, 'destroy'])->name('jenis-sampah.destroy');
});
