<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
        'kata_sandi',
        'peran',
        'status',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'dibuat_oleh');
    }
}
