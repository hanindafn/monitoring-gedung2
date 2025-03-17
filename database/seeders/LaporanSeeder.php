<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Gedung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class LaporanSeeder extends Seeder
{
    public function run()
    {
        // Ambil pengguna pertama sebagai referensi
        $user = DB::table('pengguna')->first();
        $gedung = DB::table('gedung')->first();

        if ($user && $gedung) {
            DB::table('laporan')->insert([
                'id_user' => $user->id_user,
                'id_gedung' => $gedung->id_gedung,
                'tanggal_lapor' => Carbon::now(),
                'deskripsi_kerusakan' => 'Lampu di lantai 2 mati.',
                'tipe_kerusakan' => 'Elektronik',
                'tingkat_kepentingan' => 'urgent',
                'status' => 'menunggu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            echo "Tidak ada pengguna atau gedung di database! Seeder dihentikan.\n";
        }
    }
}
