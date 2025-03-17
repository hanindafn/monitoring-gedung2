<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instansi')->insert([
            [
                'id_instansi' => 1,
                'nama_instansi' => 'Instansi A',
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_instansi' => 2,
                'nama_instansi' => 'Instansi B',
                'alamat' => 'Jl. Diponegoro No. 5, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
