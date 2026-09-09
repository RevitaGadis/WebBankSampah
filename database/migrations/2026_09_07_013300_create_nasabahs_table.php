<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id('id_nasabah');
            $table->string('no_nasabah', 20)->unique();
            $table->string('nama', 100);
            $table->string('kelas', 30);
            $table->string('no_hp', 20)->nullable();
            $table->decimal('saldo', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
