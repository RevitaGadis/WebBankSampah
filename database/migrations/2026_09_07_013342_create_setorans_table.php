<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setoran', function (Blueprint $table) {
            $table->id('id_setoran');
            $table->foreignId('id_nasabah')
                ->constrained('nasabah', 'id_nasabah')
                ->cascadeOnUpdate()
                ->restrictOnDelete(); 
            $table->foreignId('id_jenis')
                ->constrained('jenis_sampah', 'id_jenis')
                ->cascadeOnUpdate()
                ->restrictOnDelete(); 
            $table->decimal('berat', 8, 2);
            $table->decimal('harga', 10, 2); 
            $table->decimal('total', 10, 2); 
            $table->dateTime('tanggal'); 
            $table->foreignId('id_user')
                ->constrained('users', 'id_user')
                ->cascadeOnUpdate()
                ->restrictOnDelete(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
