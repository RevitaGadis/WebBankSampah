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
    private function studentArray(Nasabah $n): array
    {
        $terakhir = $n->setoran()->latest('tanggal')->first();

        return [
            'id' => $n->id_nasabah,
            'initial' => strtoupper(substr($n->nama, 0, 2)),
            'name' => $n->nama,
            'number' => $n->no_nasabah,
            'class' => $n->kelas,
            'phone' => $n->no_hp ?? '-',
            'balance' => number_format((float) $n->saldo, 0, ',', '.'),
            'count' => $n->setoran()->count(),
            'status' => 'Aktif',
            'total_weight' => number_format((float) $n->setoran()->sum('berat'), 1),
            'last_deposit' => $terakhir ? $terakhir->tanggal->format('d M Y') : '-',
            'last_deposit_item' => $terakhir
                ? $terakhir->jenisSampah->nama_jenis . ' (' . $terakhir->berat . ' Kg)'
                : '-',
        ];
    }

    public function dashboard(): View
    {
        $stats = [
            'currentDate' => now()->translatedFormat('l, d F Y'),
            'totalWeight' => number_format((float) Setoran::sum('berat'), 1) . ' Kg',
            'totalTransactions' => Setoran::count(),
            'totalBalance' => 'Rp ' . number_format((float) Nasabah::sum('saldo'), 0, ',', '.'),
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
        $students = Nasabah::orderBy('nama')->get()
            ->map(fn ($n) => $this->studentArray($n))->all();

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
        $transactions = $nasabah->setoran()->with('jenisSampah', 'petugas')
            ->latest('tanggal')->get()
            ->map(fn ($s) => TransactionFormatter::forPetugas($s))->all();

        $stats = [
            'lastUpdated' => now()->translatedFormat('d F Y, H:i') . ' WIB',
        ];

        return view('admin.rekap-nasabah', [
            'admin' => $this->admin(),
            'student' => $this->studentArray($nasabah),
            'transactions' => $transactions,
            'stats' => $stats,
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
            'class' => 'Staf Sekolah',
            'phone' => '-',
            'status' => 'Aktif',
        ])->all();

        $stats = [
            'totalAccounts' => User::count() + Nasabah::count(),
            'totalStudentAccounts' => Nasabah::where('kelas', '!=', 'Guru')->count(),
            'totalTeacherAccounts' => Nasabah::where('kelas', 'Guru')->count(),
            'totalStaffAccounts' => User::count(),
        ];

        return view('admin.akun', [
            'admin' => $this->admin(),
            'accounts' => $accounts,
            'stats' => $stats,
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
