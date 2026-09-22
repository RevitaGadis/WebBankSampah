<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NasabahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['no_nasabah' => '2026-001', 'nama' => 'Budi Santoso', 'kelas' => '7A', 'no_hp' => '081234567801'],
            ['no_nasabah' => '2026-002', 'nama' => 'Siti Aminah', 'kelas' => '7A', 'no_hp' => '081234567802'],
            ['no_nasabah' => '2026-003', 'nama' => 'Ahmad Fauzi', 'kelas' => '7B', 'no_hp' => '081234567803'],
            ['no_nasabah' => '2026-004', 'nama' => 'Dewi Lestari', 'kelas' => '7B', 'no_hp' => '081234567804'],
            ['no_nasabah' => '2026-005', 'nama' => 'Rizky Pratama', 'kelas' => '8A', 'no_hp' => '081234567805'],
            ['no_nasabah' => '2026-006', 'nama' => 'Putri Ayu', 'kelas' => '8A', 'no_hp' => null],
            ['no_nasabah' => '2026-007', 'nama' => 'Bu Ratna (Guru)', 'kelas' => 'Guru', 'no_hp' => '081234567807'],
            ['no_nasabah' => '2026-008', 'nama' => 'Fajar Nugroho', 'kelas' => '8B', 'no_hp' => '081234567808'],
            ['no_nasabah' => '2026-009', 'nama' => 'Indah Permatasari', 'kelas' => '9A', 'no_hp' => '081234567809'],
            ['no_nasabah' => '2026-010', 'nama' => 'Yusuf Maulana', 'kelas' => '9A', 'no_hp' => '081234567810'],
        ];

        foreach ($data as $item) {
            Nasabah::firstOrCreate(
                ['no_nasabah' => $item['no_nasabah']],
                [
                    'nama' => $item['nama'],
                    'kelas' => $item['kelas'],
                    'no_hp' => $item['no_hp'],
                    'saldo' => 0,
                    'password' => Hash::make('1234'),
                ]
            );
        }
    }
}
