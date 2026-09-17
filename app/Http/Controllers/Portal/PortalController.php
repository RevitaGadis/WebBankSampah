<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Support\TransactionFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalController extends Controller
{
    /**
     * $student dipakai di semua halaman portal nasabah (layout, navbar, sidebar, tiap halaman).
     * Dipusatkan di sini biar gak nulis ulang di tiap method.
     */
    private function student(): array
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $totalBerat = $nasabah->setoran()->sum('berat');

        return [
            'id' => $nasabah->id_nasabah,
            'name' => $nasabah->nama,
            'number' => $nasabah->no_nasabah,
            'class' => $nasabah->kelas,
            'phone' => $nasabah->no_hp ?? '-',
            'username' => $nasabah->no_nasabah, // gak ada username terpisah, no_nasabah yang dipakai login
            'balance' => number_format((float) $nasabah->saldo, 0, ',', '.'),
            'count' => $nasabah->setoran()->count(),
            'total_weight' => number_format((float) $totalBerat, 1) . ' Kg',
        ];
    }

    public function dashboard(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->limit(5)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.dashboard', [
            'student' => $this->student(),
            'transactions' => $transactions,
        ]);
    }

    public function riwayat(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.riwayat', [
            'student' => $this->student(),
            'transactions' => $transactions,
        ]);
    }

    public function saldo(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->limit(4)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.saldo', [
            'student' => $this->student(),
            'transactions' => $transactions,
        ]);
    }

    public function profil(): View
    {
        return view('nasabah.profil', [
            'student' => $this->student(),
        ]);
    }
}