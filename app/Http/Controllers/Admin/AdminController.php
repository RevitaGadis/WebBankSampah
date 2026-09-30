<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Models\User;
use App\Support\TransactionFormatter;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        // Satu query untuk semua jenis (sebelumnya satu query per jenis).
        $kgBulanIni = Setoran::query()
            ->selectRaw('id_jenis, SUM(berat) as total_kg')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->groupBy('id_jenis')
            ->pluck('total_kg', 'id_jenis');

        return JenisSampah::orderBy('nama_jenis')->get()->map(fn ($jenis) => [
            'id' => $jenis->id_jenis,
            'code' => 'JS' . str_pad((string) $jenis->id_jenis, 2, '0', STR_PAD_LEFT),
            'name' => $jenis->nama_jenis,
            'price' => number_format((float) $jenis->harga_per_kg, 0, ',', '.'), // untuk tampilan
            'price_raw' => (float) $jenis->harga_per_kg,                          // untuk input edit
            'unit' => 'Kg',
            'month' => number_format((float) ($kgBulanIni[$jenis->id_jenis] ?? 0), 1),
        ])->all();
    }

    /**
     * $detail = true hanya dipakai di halaman rekap (butuh query tambahan).
     * Untuk daftar nasabah, gunakan Nasabah::withCount('setoran') agar tidak N+1.
     */
    private function studentArray(Nasabah $n, bool $detail = false): array
    {
        $data = [
            'id' => $n->id_nasabah,
            'initial' => mb_strtoupper(mb_substr($n->nama, 0, 2)),
            'name' => $n->nama,
            'number' => $n->no_nasabah,
            'class' => $n->kelas,
            'phone' => $n->no_hp ?: '-',
            'balance' => number_format((float) $n->saldo, 0, ',', '.'),
            'count' => $n->setoran_count ?? $n->setoran()->count(),
            'status' => 'Aktif',
        ];

        if ($detail) {
            $terakhir = $n->setoran()->with('jenisSampah')->latest('tanggal')->first();

            $data += [
                'total_weight' => number_format((float) $n->setoran()->sum('berat'), 1),
                'last_deposit' => $terakhir ? $terakhir->tanggal->format('d M Y') : '-',
                'last_deposit_item' => $terakhir
                    ? $terakhir->jenisSampah->nama_jenis . ' (' . $terakhir->berat . ' Kg)'
                    : '-',
            ];
        }

        return $data;
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
        $students = Nasabah::withCount('setoran')->orderBy('nama')->get()
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
            'student' => $this->studentArray($nasabah, true),
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
            'role_value' => $u->role, // 'admin' / 'petugas', dipakai form edit
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

    public function storeAkun(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique(User::class, 'username')],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'petugas'])],
        ]);

        // Hapus baris Hash::make ini jika model User memakai cast 'password' => 'hashed'.
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return back()->with('sukses', 'Akun berhasil ditambahkan.');
    }

    public function updateAkun(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique(User::class, 'username')->ignore($user->id_user, 'id_user')],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'petugas'])],
        ]);

        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Anda tidak bisa menurunkan peran akun Anda sendiri.']);
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']); // hapus jika ada cast 'hashed'
        }

        $user->update($data);

        return back()->with('sukses', 'Akun berhasil diperbarui.');
    }

    public function destroyAkun(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['hapus' => 'Anda tidak bisa menghapus akun yang sedang dipakai.']);
        }

        try {
            $user->delete();
        } catch (QueryException) {
            // Foreign key dari tabel setoran menolak penghapusan.
            return back()->withErrors(['hapus' => 'Akun ini masih punya riwayat setoran, tidak bisa dihapus.']);
        }

        return back()->with('sukses', 'Akun berhasil dihapus.');
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