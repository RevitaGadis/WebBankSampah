<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran';
    protected $primaryKey = 'id_setoran';

    protected $fillable = [
        'id_nasabah',
        'id_jenis',
        'berat',
        'harga',
        'total',
        'tanggal',
        'id_user',
    ];

    protected function casts(): array
    {
        return [
            'berat' => 'decimal:2',
            'harga' => 'decimal:2',
            'total' => 'decimal:2',
            'tanggal' => 'datetime',
        ];
    }

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'id_jenis', 'id_jenis');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}