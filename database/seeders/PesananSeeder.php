<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanans')->insert([
            [
                'customer_id' => 1,
                'nomor_invoice' => 'INV-20261001-001',
                'metode_pembayaran' => 'Transfer Bank',
                'metode_pengiriman' => 'Kurir',
                'status_pesanan' => 'selesai',
                'subtotal' => 500000,
                'biaya_pengiriman' => 15000,
                'diskon' => 0,
                'total_pembayaran' => 515000,
                'catatan_pelanggan' => 'Tolong dikemas dengan baik.',
                'nama_penerima' => 'Andi Saputra',
                'nomor_telepon_penerima' => '081234567801',
                'alamat_pengiriman' => 'Jl. Perintis Kemerdekaan No. 10, Makassar',
                'tanggal_pesanan' => now()->subDays(3),
                'dikonfirmasi_pada' => now()->subDays(3),
                'diproses_pada' => now()->subDays(2),
                'dikirim_pada' => now()->subDay(),
                'diterima_pada' => now(),
                'dibatalkan_pada' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'nomor_invoice' => 'INV-20261001-002',
                'metode_pembayaran' => 'QRIS',
                'metode_pengiriman' => 'Kurir',
                'status_pesanan' => 'diproses',
                'subtotal' => 350000,
                'biaya_pengiriman' => 20000,
                'diskon' => 25000,
                'total_pembayaran' => 345000,
                'catatan_pelanggan' => null,
                'nama_penerima' => 'Budi Santoso',
                'nomor_telepon_penerima' => '081234567802',
                'alamat_pengiriman' => 'Jl. Sultan Alauddin No. 25, Makassar',
                'tanggal_pesanan' => now()->subDay(),
                'dikonfirmasi_pada' => now()->subDay(),
                'diproses_pada' => now(),
                'dikirim_pada' => null,
                'diterima_pada' => null,
                'dibatalkan_pada' => null,
                'created_at' => now()->subDay(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'nomor_invoice' => 'INV-20261001-003',
                'metode_pembayaran' => 'Cash',
                'metode_pengiriman' => 'Ambil di Toko',
                'status_pesanan' => 'pending',
                'subtotal' => 175000,
                'biaya_pengiriman' => 0,
                'diskon' => 0,
                'total_pembayaran' => 175000,
                'catatan_pelanggan' => 'Akan diambil sore hari.',
                'nama_penerima' => 'Citra Lestari',
                'nomor_telepon_penerima' => '081234567803',
                'alamat_pengiriman' => 'Jl. AP Pettarani No. 45, Makassar',
                'tanggal_pesanan' => now(),
                'dikonfirmasi_pada' => null,
                'diproses_pada' => null,
                'dikirim_pada' => null,
                'diterima_pada' => null,
                'dibatalkan_pada' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}