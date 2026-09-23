<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdKategoriSampah;

class KategoriSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Organik', 'Anorganik', 'B3 / Spesifik'
        ];

        foreach ($datas as $data) {
            $mdKategoriSampah = new MdKategoriSampah;
            $mdKategoriSampah->user_id = 1;
            $mdKategoriSampah->nama = $data;
            $mdKategoriSampah->save();
        }
    }
}
