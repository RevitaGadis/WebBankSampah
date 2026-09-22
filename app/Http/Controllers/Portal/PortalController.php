<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Support\TransactionFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalController extends Controller
{
    private function student(): array
    {
        /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $totalBerat = $nasabah->setoran()->sum('berat');
        $terakhir = $nasabah->setoran()->latest('tanggal')->first();

        return [
            'id' => $nasabah->id_nasabah,
            'initial' => strtoupper(substr($nasabah->nama, 0, 2)),
            'name' => $nasabah->nama,
            'number' => $nasabah->no_nasabah,
            'class' => $nasabah->kelas,
            'phone' => $nasabah->no_hp ?? '-',
            'username' => $nasabah->no_nasabah,
            'balance' => number_format((float) $nasabah->saldo, 0, ',', '.'),
            'count' => $nasabah->setoran()->count(),
            'status' => 'Aktif',
            'total_weight' => number_format((float) $totalBerat, 1) . ' Kg',
            'last_deposit' => $terakhir ? $terakhir->tanggal->format('d M Y') : '-',
            'last_deposit_item' => $terakhir
                ? $terakhir->jenisSampah->nama_jenis . ' (' . $terakhir->berat . ' Kg)'
                : '-',
            'last_activity_desc' => $terakhir
                ? 'Penyetoran ' . $terakhir->berat . ' Kg ' . $terakhir->jenisSampah->nama_jenis
                : 'Belum ada aktivitas',
            'last_activity_time' => $terakhir ? $terakhir->tanggal->format('d M Y, H:i') . ' WIB' : '-',
            'book_number' => 'BK-' . str_pad((string) $nasabah->id_nasabah, 4, '0', STR_PAD_LEFT),
            'last_change' => $terakhir ? '+ Rp ' . number_format((float) $terakhir->total, 0, ',', '.') : '-',
            'last_change_desc' => $terakhir ? $terakhir->tanggal->diffForHumans() : '-',
        ];
    }

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
            'student' => $this->student(),
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
            'student' => $this->student(),
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
            'student' => $this->student(),
            'stats' => $stats,
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
