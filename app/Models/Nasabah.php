<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nasabah extends Authenticatable
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

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'saldo' => 'decimal:2',
            'password' => 'hashed',
        ];
    }

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class, 'id_nasabah', 'id_nasabah');
    }
    public function tambahSaldo(float $jumlah): void
    {
        $this->increment('saldo', $jumlah);
    }
}