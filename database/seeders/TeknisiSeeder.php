<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teknisi')->insert([
            [
                'id_teknisi' => 1,
                'nama_teknisi' => 'Budi Santoso',
                'kontak' => '08123456789',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_teknisi' => 2,
                'nama_teknisi' => 'Agus Saputra',
                'kontak' => '08198765432',
                'status' => 'sibuk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
