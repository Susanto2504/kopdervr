<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    protected $fillable = [
        'customer_id',
        'nomor_invoice',
        'metode_pembayaran',
        'metode_pengiriman',
        'status_pesanan',
        'subtotal',
        'biaya_pengiriman',
        'diskon',
        'total_pembayaran',
        'catatan_pelanggan',
        'nama_penerima',
        'nomor_telepon_penerima',
        'alamat_pengiriman',
        'tanggal_pesanan',
        'dikonfirmasi_pada',
        'diproses_pada',
        'dikirim_pada',
        'diterima_pada',
        'dibatalkan_pada',
        'xendit_qr_id',
        'status_pembayaran',
        'xendit_payment_id',
        'dibayar_pada',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'biaya_pengiriman' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
        'tanggal_pesanan' => 'datetime',
        'dikonfirmasi_pada' => 'datetime',
        'diproses_pada' => 'datetime',
        'dikirim_pada' => 'datetime',
        'diterima_pada' => 'datetime',
        'dibatalkan_pada' => 'datetime',
        'dibayar_pada' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
