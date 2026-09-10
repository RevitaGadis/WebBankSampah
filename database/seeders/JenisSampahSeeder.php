<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use Illuminate\Database\Seeder;

class JenisSampahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_jenis' => 'Plastik', 'harga_per_kg' => 3000],
            ['nama_jenis' => 'Kardus', 'harga_per_kg' => 2000],
            ['nama_jenis' => 'Kertas', 'harga_per_kg' => 2500],
            ['nama_jenis' => 'Botol Plastik', 'harga_per_kg' => 4000],
        ];

        foreach ($data as $item) {
            JenisSampah::firstOrCreate(['nama_jenis' => $item['nama_jenis']], $item);
        }
    }
}
