<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nasabah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nasabah';
    protected $primaryKey = 'id_nasabah';

    protected $fillable = [
        'no_nasabah',
        'nama',
        'kelas',
        'no_hp',
        'saldo',
    ];

    protected function casts(): array
    {
        return [
            'saldo' => 'decimal:2',
        ];
    }

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class, 'id_nasabah', 'id_nasabah');
    }

    // Tambah saldo dengan aman (dipanggil di dalam DB::transaction saat input setoran)
    public function tambahSaldo(float $jumlah): void
    {
        $this->increment('saldo', $jumlah);
    }
}