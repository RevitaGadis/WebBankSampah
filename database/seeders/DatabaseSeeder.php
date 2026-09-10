<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JenisSampahSeeder::class,
            NasabahSeeder::class,
            SetoranSeeder::class, // jalan terakhir, butuh 3 seeder di atas udah ada datanya
        ]);
    }
}
