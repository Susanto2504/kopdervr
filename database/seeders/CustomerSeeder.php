<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'nama' => 'Andi Saputra',
                'alamat' => 'Jl. Perintis Kemerdekaan No. 10, Makassar',
                'nomor_telepon' => '081234567801',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Sultan Alauddin No. 25, Makassar',
                'nomor_telepon' => '081234567802',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Citra Lestari',
                'alamat' => 'Jl. AP Pettarani No. 45, Makassar',
                'nomor_telepon' => '081234567803',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dian Pratama',
                'alamat' => 'Jl. Hertasning No. 12, Makassar',
                'nomor_telepon' => '081234567804',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eka Putri',
                'alamat' => 'Jl. Toddopuli No. 8, Makassar',
                'nomor_telepon' => '081234567805',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}