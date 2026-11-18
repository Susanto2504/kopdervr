<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            [
                'nama' => 'Sembako',
                'deskripsi' => 'Berbagai kebutuhan pokok sehari-hari seperti beras, minyak goreng, gula, dan tepung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Minuman',
                'deskripsi' => 'Berbagai jenis minuman seperti air mineral, susu, teh, kopi, dan minuman kemasan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Makanan',
                'deskripsi' => 'Berbagai jenis makanan dan camilan untuk kebutuhan sehari-hari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sabun',
                'deskripsi' => 'Berbagai produk sabun untuk mandi, mencuci, dan membersihkan kebutuhan rumah tangga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
