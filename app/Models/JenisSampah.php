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

    public static function ringkasan(): array
    {
        return self::orderBy('nama_jenis')->get()->map(function ($jenis, $i) {
            $kgBulanIni = Setoran::where('id_jenis', $jenis->id_jenis)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('berat');

            return [
                'id' => $jenis->id_jenis,
                'code' => 'JS' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                'name' => $jenis->nama_jenis,
                'price' => number_format((float) $jenis->harga_per_kg, 0, ',', '.'),
                'unit' => 'Kg',
                'month' => number_format((float) $kgBulanIni, 1),
            ];
        })->all();
    }
}