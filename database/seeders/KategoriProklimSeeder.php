<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdKategoriProklim;

class KategoriProklimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Pratama',
            'Utama',
            'Trophy Utama',
            'Madya'
        ];

        foreach ($datas as $data) {
            $mdKategoriProklim = new MdKategoriProklim;
            $mdKategoriProklim->user_id = 1;
            $mdKategoriProklim->nama = $data;
            $mdKategoriProklim->save();
        }
    }
}
