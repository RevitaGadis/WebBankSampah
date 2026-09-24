<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nasabah extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'nasabah';
    protected $primaryKey = 'id_nasabah';
    protected $fillable = ['no_nasabah', 'nama', 'kelas', 'no_hp', 'saldo'];
    protected $hidden = ['password'];

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

    public function toRingkas(): array
    {
        $terakhir = $this->setoran()->latest('tanggal')->first();

        return [
            'id' => $this->id_nasabah,
            'initial' => strtoupper(substr($this->nama, 0, 2)),
            'name' => $this->nama,
            'number' => $this->no_nasabah,
            'class' => $this->kelas,
            'phone' => $this->no_hp ?? '-',
            'balance' => number_format((float) $this->saldo, 0, ',', '.'),
            'count' => $this->setoran()->count(),
            'status' => 'Aktif',
            'total_weight' => number_format((float) $this->setoran()->sum('berat'), 1),
            'last_deposit' => $terakhir ? $terakhir->tanggal->format('d M Y') : '-',
            'last_deposit_item' => $terakhir
                ? $terakhir->jenisSampah->nama_jenis . ' (' . $terakhir->berat . ' Kg)'
                : '-',
        ];
    }

    public function toLengkap(): array
    {
        $terakhir = $this->setoran()->latest('tanggal')->first();
        $dasar = $this->toRingkas();

        return array_merge($dasar, [
            'username' => $this->no_nasabah,
            'total_weight' => $dasar['total_weight'] . ' Kg',
            'last_activity_desc' => $terakhir
                ? 'Penyetoran ' . $terakhir->berat . ' Kg ' . $terakhir->jenisSampah->nama_jenis
                : 'Belum ada aktivitas',
            'last_activity_time' => $terakhir ? $terakhir->tanggal->format('d M Y, H:i') . ' WIB' : '-',
            'book_number' => 'BK-' . str_pad((string) $this->id_nasabah, 4, '0', STR_PAD_LEFT),
            'last_change' => $terakhir ? '+ Rp ' . number_format((float) $terakhir->total, 0, ',', '.') : '-',
            'last_change_desc' => $terakhir ? $terakhir->tanggal->diffForHumans() : '-',
        ]);
    }
}