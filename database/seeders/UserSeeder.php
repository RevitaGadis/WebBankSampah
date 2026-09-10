<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            ['nama' => 'Administrator', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['username' => 'petugas1'],
            ['nama' => 'Petugas Satu', 'password' => Hash::make('petugas123'), 'role' => 'petugas']
        );
    }
}
