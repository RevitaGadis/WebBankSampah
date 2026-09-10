<?php

namespace App\Services;

use App\Models\Nasabah;
use Illuminate\Support\Facades\Hash;

class NasabahService
{
    public function buatNasabah(array $data): Nasabah
    {
        return Nasabah::create([
            'no_nasabah' => $this->generateNoNasabah(),
            'nama' => $data['nama'],
            'kelas' => $data['kelas'],
            'no_hp' => $data['no_hp'] ?? null,
            'password' => Hash::make($data['pin']),
            'saldo' => 0,
        ]);
    }

    public function updateNasabah(Nasabah $nasabah, array $data): Nasabah
    {
        $nasabah->nama = $data['nama'];
        $nasabah->kelas = $data['kelas'];
        $nasabah->no_hp = $data['no_hp'] ?? null;

        if (!empty($data['pin'])) {
            $nasabah->password = Hash::make($data['pin']);
        }

        $nasabah->save();

        return $nasabah;
    }

    public function generateNoNasabah(): string
    {
        $tahun = date('Y');
        $terakhir = Nasabah::withTrashed()
            ->where('no_nasabah', 'like', "{$tahun}-%")
            ->orderByDesc('id_nasabah')
            ->first();

        $urutan = 1;
        if ($terakhir) {
            $bagian = explode('-', $terakhir->no_nasabah);
            $urutan = (int) end($bagian) + 1;
        }

        return sprintf('%s-%03d', $tahun, $urutan);
    }
}
