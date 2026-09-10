<?php

namespace App\Services;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use Illuminate\Support\Facades\DB;

class SetoranService
{
    /**
     * Proses satu transaksi setoran: hitung total, simpan, dan update saldo nasabah.
     * Dibungkus DB::transaction() biar atomic — kalau ada yang gagal di tengah,
     * semua di-rollback (saldo TIDAK ikut nambah kalau insert gagal, atau sebaliknya).
     */
    public function prosesSetoran(array $data, int $idPetugas): Setoran
    {
        return DB::transaction(function () use ($data, $idPetugas) {
            $jenis = JenisSampah::findOrFail($data['id_jenis']);
            $nasabah = Nasabah::findOrFail($data['id_nasabah']);

            $berat = (float) $data['berat'];
            $hargaSaatIni = (float) $jenis->harga_per_kg;
            $total = $berat * $hargaSaatIni;

            $setoran = Setoran::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_jenis' => $jenis->id_jenis,
                'berat' => $berat,
                'harga' => $hargaSaatIni, // snapshot harga saat transaksi, bukan referensi live
                'total' => $total,
                'tanggal' => now(),
                'id_user' => $idPetugas,
            ]);

            $nasabah->tambahSaldo($total);

            return $setoran->load(['nasabah', 'jenisSampah', 'petugas']);
        });
    }
}
