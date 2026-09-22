<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\User;
use App\Services\SetoranService;
use Illuminate\Database\Seeder;

class SetoranSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = User::where('role', 'petugas')->first() ?? User::first();
        $jenisSampah = JenisSampah::all();
        $nasabah = Nasabah::all();

        if ($jenisSampah->isEmpty() || $nasabah->isEmpty() || !$petugas) {
            $this->command->warn('Jalankan JenisSampahSeeder, NasabahSeeder, dan UserSeeder dulu sebelum SetoranSeeder.');
            return;
        }

        $service = app(SetoranService::class);
        for ($i = 0; $i < 15; $i++) {
            $service->prosesSetoran([
                'id_nasabah' => $nasabah->random()->id_nasabah,
                'id_jenis' => $jenisSampah->random()->id_jenis,
                'berat' => fake()->randomFloat(2, 0.5, 10),
            ], $petugas->id_user);
        }

        $this->command->info('15 transaksi setoran dummy berhasil dibuat, saldo nasabah ikut ke-update.');
    }
}
