<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Support\TransactionFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $stats = [
            'totalWeight' => number_format((float) $nasabah->setoran()->sum('berat'), 1) . ' Kg',
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'totalWeightDesc' => 'Total sampah yang sudah kamu setor',
            'totalDepositsDesc' => 'Semua setoran terverifikasi petugas',
            'totalIncomeDesc' => 'Kumulatif kredit masuk ke saldo',
        ];

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->limit(5)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.dashboard', [
            'student' => $nasabah->toLengkap(),
            'stats' => $stats,
            'transactions' => $transactions,
        ]);
    }

    public function riwayat(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $beratBulanIni = $nasabah->setoran()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('berat');

        $nilaiBulanIni = $nasabah->setoran()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total');

        $stats = [
            'monthlyWeight' => number_format((float) $beratBulanIni, 1) . ' Kg',
            'monthlyWeightDesc' => now()->translatedFormat('F Y'),
            'monthlyIncome' => 'Rp ' . number_format((float) $nilaiBulanIni, 0, ',', '.'),
            'monthlyIncomeDesc' => 'Terkreditasi langsung ke saldo utama',
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'totalPages' => 1,
            'activeOfficers' => 'Petugas Piket',
        ];

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.riwayat', [
            'student' => $nasabah->toLengkap(),
            'stats' => $stats,
            'transactions' => $transactions,
        ]);
    }

    public function saldo(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $totalBerat = $nasabah->setoran()->sum('berat');
        $terakhir = $nasabah->setoran()->latest('tanggal')->first();

        $stats = [
            'totalTransactionsDesc' => 'Setoran sampah terverifikasi',
            'totalWeight' => number_format((float) $totalBerat, 1) . ' Kg',
            'totalWeightDesc' => 'Terkonversi ke circular economy',
            'totalIncomeDesc' => 'Kumulatif kredit masuk aktif',
            'lastDepositDate' => $terakhir ? $terakhir->tanggal->format('d M Y') : '-',
            'currentDate' => now()->translatedFormat('l, d F Y'),
        ];

        $transactions = $nasabah->setoran()
            ->with('jenisSampah', 'petugas')
            ->latest('tanggal')
            ->limit(4)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forNasabah($s))
            ->all();

        return view('nasabah.saldo', [
            'student' => $nasabah->toLengkap(),
            'stats' => $stats,
            'transactions' => $transactions,
        ]);
    }

    public function profil(): View
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        return view('nasabah.profil', [
            'student' => $nasabah->toLengkap(),
        ]);
    }
}