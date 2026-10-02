<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('nama_jenis', 100)->unique();
            $table->decimal('harga_per_kg', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_sampah');
    }
};
