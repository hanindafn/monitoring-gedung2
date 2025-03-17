<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gedung')->insert([
            [
                'id_gedung' => 1,
                'id_instansi' => 1,
                'nama_gedung' => 'Gedung Utama',
                'alamat_gedung' => 'Jl. Merdeka No. 1, Jakarta',
                'jumlah_lantai' => 5,
                'fasilitas' => 'Ruang Meeting, Kantin, Parkir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_gedung' => 2,
                'id_instansi' => 2,
                'nama_gedung' => 'Gedung B',
                'alamat_gedung' => 'Jl. Diponegoro No. 5, Bandung',
                'jumlah_lantai' => 3,
                'fasilitas' => 'AC, Lift, WiFi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
