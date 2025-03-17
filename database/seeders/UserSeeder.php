<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id_user' => 1,
                'id_instansi' => 1,
                'nama_user' => 'Admin User',
                'nip' => '1234567890',
                'email' => 'admin@example.com',
                'no_hp' => '081234567890',
                'password' => Hash::make('admin'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'id_instansi' => 1,
                'nama_user' => 'User Pelapor',
                'nip' => '0987654321',
                'email' => 'user@example.com',
                'no_hp' => '081987654321',
                'password' => Hash::make('user'),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
