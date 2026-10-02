<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSampah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_sampah';
    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_jenis',
        'harga_per_kg',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'decimal:2',
        ];
    }

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class, 'id_jenis', 'id_jenis');
    }
}