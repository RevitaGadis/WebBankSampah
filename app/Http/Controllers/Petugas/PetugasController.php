<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Support\TransactionFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PetugasController extends Controller
{
    /**
     * $officer dipakai di semua halaman petugas (navbar, sidebar).
     * Dipusatkan di sini biar gak nulis ulang di tiap method.
     */
    private function officer(): array
    {
        $user = Auth::guard('web')->user();

        return [
            'name' => $user->nama,
            'role' => $user->role === 'admin' ? 'Administrator' : 'Petugas Piket',
        ];
    }

    /**
     * $waste dipakai di halaman setoran (pilihan jenis sampah) dan jenis-sampah (katalog).
     * 'month' = total kg jenis itu yang disetor bulan ini.
     */
    private function waste(): array
    {
        return JenisSampah::orderBy('nama_jenis')->get()->map(function ($jenis, $i) {
            $kgBulanIni = Setoran::where('id_jenis', $jenis->id_jenis)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('berat');

            return [
                'id' => $jenis->id_jenis,
                'code' => 'JS' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                'name' => $jenis->nama_jenis,
                'price' => number_format((float) $jenis->harga_per_kg, 0, ',', '.'),
                'unit' => 'Kg',
                'month' => number_format((float) $kgBulanIni, 1),
                'detail' => '',
            ];
        })->all();
    }

    public function dashboard(): View
    {
        $today = now()->toDateString();

        $setoranHariIni = Setoran::whereDate('tanggal', $today);
        $totalHariIni = (clone $setoranHariIni)->count();
        $beratHariIni = (clone $setoranHariIni)->sum('berat');
        $nilaiHariIni = (clone $setoranHariIni)->sum('total');

        $stats = [
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'todayDeposits' => $totalHariIni . ' Setoran',
            'todayWeight' => number_format((float) $beratHariIni, 1) . ' Kg',
            'todayTransactions' => $totalHariIni . ' Transaksi',
            'todayBalance' => 'Rp ' . number_format((float) $nilaiHariIni, 0, ',', '.'),
        ];

        $transactions = Setoran::with(['nasabah', 'jenisSampah', 'petugas'])
            ->latest('tanggal')
            ->limit(10)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))
            ->all();

        return view('petugas.dashboard', [
            'officer' => $this->officer(),
            'stats' => $stats,
            'transactions' => $transactions,
            'waste' => $this->waste(),
        ]);
    }

    public function setoran(): View
    {
        $beratBulanIni = Setoran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('berat');

        $stats = [
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'todayWeight' => number_format((float) $beratBulanIni, 1) . ' Kg',
        ];

        $transactions = Setoran::with(['nasabah', 'jenisSampah', 'petugas'])
            ->latest('tanggal')
            ->limit(10)
            ->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))
            ->all();

        return view('petugas.setoran', [
            'officer' => $this->officer(),
            'stats' => $stats,
            'transactions' => $transactions,
            'waste' => $this->waste(),
        ]);
    }

    public function nasabah(): View
    {
        $students = Nasabah::withCount('setoran')->orderBy('nama')->get()->map(fn ($n) => [
            'id' => $n->id_nasabah,
            'name' => $n->nama,
            'number' => $n->no_nasabah,
            'class' => $n->kelas,
            'phone' => $n->no_hp ?? '-',
            'count' => $n->setoran_count,
            'balance' => number_format((float) $n->saldo, 0, ',', '.'),
            'status' => 'Aktif',
        ])->all();

        $stats = [
            'totalStudents' => Nasabah::where('kelas', '!=', 'Guru')->count(),
            'totalTeachers' => Nasabah::where('kelas', 'Guru')->count(),
            'totalBalance' => 'Rp ' . number_format((float) Nasabah::sum('saldo'), 0, ',', '.'),
        ];

        return view('petugas.nasabah', [
            'officer' => $this->officer(),
            'stats' => $stats,
            'students' => $students,
        ]);
    }

    public function jenisSampah(): View
    {
        return view('petugas.jenis-sampah', [
            'officer' => $this->officer(),
            'waste' => $this->waste(),
        ]);
    }

    public function riwayat(): View
    {
        $totalTransaksi = Setoran::count();
        $totalBerat = Setoran::sum('berat');
        $totalNilai = Setoran::sum('total');

        $stats = [
            'totalTransactions' => $totalTransaksi,
            'totalWeight' => number_format((float) $totalBerat, 1),
            'totalBalance' => number_format((float) $totalNilai, 0, ',', '.'),
            'avgTransaction' => $totalTransaksi > 0
                ? number_format($totalNilai / $totalTransaksi, 0, ',', '.')
                : '0',
        ];

        $transactions = Setoran::with(['nasabah', 'jenisSampah', 'petugas'])
            ->latest('tanggal')
            ->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))
            ->all();

        return view('petugas.riwayat', [
            'officer' => $this->officer(),
            'stats' => $stats,
            'transactions' => $transactions,
        ]);
    }
}
