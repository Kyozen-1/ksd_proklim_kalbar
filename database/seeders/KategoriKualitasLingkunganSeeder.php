<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdKategoriKualitasLingkungan;

class KategoriKualitasLingkunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Air', 'Tutupan Lahan', 'Udara'
        ];

        foreach ($datas as $data) {
            $mdKategoriKualitasLingkungan = new MdKategoriKualitasLingkungan;
            $mdKategoriKualitasLingkungan->user_id = 1;
            $mdKategoriKualitasLingkungan->nama = $data;
            $mdKategoriKualitasLingkungan->save();
        }
    }
}
