<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\Portal\PetugasController;
use App\Http\Controllers\Portal\AdminController;

Route::get('/', function () {
    return redirect()->route('nasabah.login');
});

Route::prefix('nasabah')->name('nasabah.')->controller(PortalController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/riwayat-setoran', 'riwayat')->name('riwayat');
    Route::get('/saldo-tabungan', 'saldo')->name('saldo');
    Route::get('/profil', 'profil')->name('profil');
});

Route::post('/nasabah/logout', function (Request $request) {
    if (auth()->check()) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route('nasabah.login');
})->name('nasabah.logout');

Route::prefix('petugas')->name('petugas.')->controller(PetugasController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/setoran', 'setoran')->name('setoran');
    Route::get('/nasabah', 'nasabah')->name('nasabah');
    Route::get('/jenis-sampah', 'jenisSampah')->name('jenis-sampah');
    Route::get('/riwayat', 'riwayat')->name('riwayat');
});

Route::post('/petugas/logout', function (Request $request) {
    if (auth()->check()) { auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); }
    return redirect()->route('nasabah.login');
})->name('petugas.logout');

Route::prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/nasabah', 'nasabah')->name('nasabah');
    Route::get('/nasabah/rekap/{number}', 'rekapNasabah')->name('nasabah.rekap');
    Route::get('/jenis-sampah', 'jenisSampah')->name('jenis-sampah');
    Route::get('/akun', 'akun')->name('akun');
    Route::get('/riwayat', 'riwayat')->name('riwayat');
});

Route::post('/admin/logout', function (Request $request) {
    if (auth()->check()) { auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); }
    return redirect()->route('nasabah.login');
})->name('admin.logout');
