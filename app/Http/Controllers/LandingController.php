<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $stats = [
            'totalNasabah' => Nasabah::count(),
            'totalBerat' => number_format((float) Setoran::sum('berat'), 1, ',', '.'),
            'totalNilai' => number_format((float) Setoran::sum('total'), 0, ',', '.'),
            'setoranBulanIni' => Setoran::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
        ];

        $waste = JenisSampah::orderBy('nama_jenis')->get()->map(function ($item, $i) {
            return [
                'code' => 'JS-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                'name' => $item->nama_jenis,
                'category' => $this->kategoriDari($item->nama_jenis),
                'price' => number_format((float) $item->harga_per_kg, 0, ',', '.'),
            ];
        })->all();

        $recentTransactions = Setoran::with(['nasabah', 'jenisSampah'])
            ->latest('tanggal')
            ->limit(5)
            ->get()
            ->map(fn ($s) => [
                'time' => $s->tanggal->diffForHumans(),
                'identity' => $this->maskIdentitas($s->nasabah),
                'class' => $s->nasabah->kelas,
                'jenis' => $s->jenisSampah->nama_jenis,
                'weight' => number_format((float) $s->berat, 1) . ' Kg',
                'total' => number_format((float) $s->total, 0, ',', '.'),
            ])
            ->all();

        return view('welcome', compact('stats', 'waste', 'recentTransactions'));
    }

    /**
     * Kategori ini cuma dipakai untuk tombol filter di tampilan,
     * ditebak dari kata kunci pada nama_jenis — bukan kolom database sungguhan.
     * Kalau mau akurat 100%, perlu kolom kategori baru lewat migration.
     */
    private function kategoriDari(string $nama): string
    {
        $nama = strtolower($nama);

        return match (true) {
            str_contains($nama, 'plastik') || str_contains($nama, 'botol') => 'plastik',
            str_contains($nama, 'kertas') || str_contains($nama, 'kardus') || str_contains($nama, 'dupleks') => 'kertas',
            str_contains($nama, 'kaleng') || str_contains($nama, 'alumin') || str_contains($nama, 'logam') => 'logam',
            str_contains($nama, 'minyak') => 'minyak',
            default => 'lainnya',
        };
    }

    private function maskIdentitas(Nasabah $nasabah): string
    {
        $peran = $nasabah->kelas === 'Guru' ? 'Guru' : 'Siswa';
        $inisial = strtoupper(substr($nasabah->nama, 0, 1));

        return "{$peran} {$inisial}***";
    }
}