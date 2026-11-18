<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detail_pesanans')->insert([
            [
                'pesanan_id' => 1,
                'barang_id' => 1,
                'nama_barang' => 'Keyboard Mechanical',
                'sku' => 'KB-MECH-001',
                'harga' => 450000,
                'jumlah' => 1,
                'subtotal' => 450000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 1,
                'barang_id' => 3,
                'nama_barang' => 'Kabel USB Type C',
                'sku' => 'USB-C-001',
                'harga' => 55000,
                'jumlah' => 1,
                'subtotal' => 55000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 2,
                'barang_id' => 2,
                'nama_barang' => 'Mouse Wireless',
                'sku' => 'MS-WRL-001',
                'harga' => 175000,
                'jumlah' => 2,
                'subtotal' => 350000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 3,
                'barang_id' => 2,
                'nama_barang' => 'Mouse Wireless',
                'sku' => 'MS-WRL-001',
                'harga' => 175000,
                'jumlah' => 1,
                'subtotal' => 175000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}