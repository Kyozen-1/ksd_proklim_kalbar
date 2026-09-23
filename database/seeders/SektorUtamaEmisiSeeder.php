<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdSektorUtamaEmisi;

class SektorUtamaEmisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Folu (Kehutanan & Lahan)',
            'Energi & Transportasi',
            'Pengolahan Limbah',
            'Pertanian & Peternakan',
            'IPPU (Industri)'
        ];

        foreach ($datas as $data) {
            $mdSektorUtamaEmisi = new MdSektorUtamaEmisi;
            $mdSektorUtamaEmisi->user_id = 1;
            $mdSektorUtamaEmisi->nama = $data;
            $mdSektorUtamaEmisi->save();
        }
    }
}
