<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // BengkayangSeeder::class,
            // KapuasHuluSeeder::class,
            // KetapangSeeder::class,
            // KubuRayaSeeder::class,
            // LandakSeeder::class,
            // MelawiSeeder::class,
            // MempawahSeeder::class,
            // PontianakSeeder::class,
            // SambasSeeder::class,
            // SanggauSeeder::class,
            // SekadauSeeder::class,
            // SingkawangSeeder::class,
            // SintangSeeder::class,
            // KayongUtaraSeeder::class,
            // UserSeeder::class,
            KategoriProklimSeeder::class,
            SektorUtamaEmisiSeeder::class,
            JenisEmisiSeeder::class,
            KategoriSampahSeeder::class,
            KategoriKualitasLingkunganSeeder::class,
            SektorLb3Seeder::class,
        ]);
    }
}
