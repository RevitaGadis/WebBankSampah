<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Models\User;
use App\Support\TransactionFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    private function admin(): array
    {
        $user = Auth::guard('web')->user();

        return [
            'name' => $user->nama,
            'role' => 'Administrator',
        ];
    }

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
            ];
        })->all();
    }

    public function dashboard(): View
    {
        $stats = [
            'totalSampahKg' => number_format((float) Setoran::sum('berat'), 1),
            'totalTransaksi' => Setoran::count(),
            'totalSaldoBeredar' => number_format((float) Nasabah::sum('saldo'), 0, ',', '.'),
        ];

        $transactions = Setoran::with(['nasabah', 'jenisSampah', 'petugas'])
            ->latest('tanggal')->limit(10)->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))->all();

        return view('admin.dashboard', [
            'admin' => $this->admin(),
            'stats' => $stats,
            'transactions' => $transactions,
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
            'initial' => strtoupper(substr($n->nama, 0, 2)),
        ])->all();

        $stats = [
            'totalStudents' => Nasabah::where('kelas', '!=', 'Guru')->count(),
            'totalTeachers' => Nasabah::where('kelas', 'Guru')->count(),
            'totalBalance' => 'Rp ' . number_format((float) Nasabah::sum('saldo'), 0, ',', '.'),
        ];

        return view('admin.nasabah', [
            'admin' => $this->admin(),
            'students' => $students,
            'stats' => $stats,
        ]);
    }

    public function rekapNasabah(Nasabah $nasabah): View
    {
        $riwayat = $nasabah->setoran()->with('jenisSampah', 'petugas')
            ->latest('tanggal')->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))->all();

        return view('admin.rekap-nasabah', [
            'admin' => $this->admin(),
            'nasabah' => $nasabah,
            'riwayat' => $riwayat,
        ]);
    }

    public function jenisSampah(): View
    {
        $waste = $this->waste();

        $hargaTertinggi = JenisSampah::orderByDesc('harga_per_kg')->first();

        $stats = [
            'totalCategories' => count($waste),
            'avgPrice' => number_format((float) JenisSampah::avg('harga_per_kg'), 0, ',', '.'),
            'highestPrice' => $hargaTertinggi ? number_format((float) $hargaTertinggi->harga_per_kg, 0, ',', '.') : '0',
            'highestPriceItem' => $hargaTertinggi?->nama_jenis ?? '-',
        ];

        return view('admin.jenis-sampah', [
            'admin' => $this->admin(),
            'waste' => $waste,
            'stats' => $stats,
        ]);
    }

    public function akun(): View
    {
        $accounts = User::orderBy('nama')->get()->map(fn ($u) => [
            'id' => $u->id_user,
            'number' => $u->username,
            'name' => $u->nama,
            'username' => $u->username,
            'role' => $u->role === 'admin' ? 'Administrator' : 'Petugas',
            'class' => 'Staf Sekolah', // users gak punya kolom kelas, disamain aja
            'phone' => '-', // users gak punya kolom no_hp di skema kita
            'status' => 'Aktif',
        ])->all();

        return view('admin.akun', [
            'admin' => $this->admin(),
            'accounts' => $accounts,
        ]);
    }

    public function riwayat(): View
    {
        $totalTransaksi = Setoran::count();
        $totalNilai = Setoran::sum('total');

        $stats = [
            'totalTransactions' => $totalTransaksi,
            'totalWeight' => number_format((float) Setoran::sum('berat'), 1),
            'totalBalance' => number_format((float) $totalNilai, 0, ',', '.'),
            'avgTransaction' => $totalTransaksi > 0 ? number_format($totalNilai / $totalTransaksi, 0, ',', '.') : '0',
        ];

        $transactions = Setoran::with(['nasabah', 'jenisSampah', 'petugas'])
            ->latest('tanggal')->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))->all();

        return view('admin.riwayat', [
            'admin' => $this->admin(),
            'stats' => $stats,
            'transactions' => $transactions,
        ]);
    }
}
