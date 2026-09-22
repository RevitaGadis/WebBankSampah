<?php

namespace App\Support;

use App\Models\Setoran;

class TransactionFormatter
{
    public static function forPetugas(Setoran $s): array
    {
        return [
            'id' => 'TRX-' . str_pad((string) $s->id_setoran, 4, '0', STR_PAD_LEFT),
            'date' => $s->tanggal->format('d/m/Y'),
            'time' => $s->tanggal->format('H:i'),
            'name' => $s->nasabah->nama,
            'number' => $s->nasabah->no_nasabah,
            'class' => $s->nasabah->kelas,
            'phone' => $s->nasabah->no_hp ?? '-',
            'jenis' => $s->jenisSampah->nama_jenis,
            'weight' => number_format((float) $s->berat, 1),
            'price' => number_format((float) $s->harga, 0, ',', '.'),
            'total' => number_format((float) $s->total, 0, ',', '.'),
            'officer' => $s->petugas->nama,
            'status' => 'Selesai',
            'balance_before' => number_format((float) $s->nasabah->saldo - (float) $s->total, 0, ',', '.'),
            'balance_after' => number_format((float) $s->nasabah->saldo, 0, ',', '.'),
        ];
    }
    public static function forNasabah(Setoran $s): array
    {
        return [
            'id' => 'TRX-' . str_pad((string) $s->id_setoran, 4, '0', STR_PAD_LEFT),
            'date' => $s->tanggal->format('d/m/Y'),
            'time' => $s->tanggal->format('H:i'),
            'jenis' => $s->jenisSampah->nama_jenis,
            'weight' => number_format((float) $s->berat, 1),
            'price' => number_format((float) $s->harga, 0, ',', '.'),
            'total' => number_format((float) $s->total, 0, ',', '.'),
            'officer' => $s->petugas->nama,
            'initial' => strtoupper(substr($s->petugas->nama, 0, 2)),
            'detail' => $s->jenisSampah->nama_jenis . ' - ' . number_format((float) $s->berat, 1) . ' Kg',
            'balance' => number_format((float) $s->nasabah->saldo, 0, ',', '.'),
        ];
    }
}
