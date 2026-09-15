<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class, 'id_user', 'id_user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}