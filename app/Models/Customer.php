<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telepon',
    ];

     public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}
