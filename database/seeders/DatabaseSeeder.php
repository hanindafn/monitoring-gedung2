<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            InstansiSeeder::class,
            GedungSeeder::class,
            TeknisiSeeder::class,
            UserSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}
