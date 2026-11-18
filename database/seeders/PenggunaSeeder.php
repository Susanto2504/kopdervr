<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penggunas')->insert([
            [
                'nama' => 'Administrator',
                'email' => 'admin@tokoku2.com',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
