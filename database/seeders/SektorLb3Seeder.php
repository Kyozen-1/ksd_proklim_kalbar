<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdSektorLb3;

class SektorLb3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Industri', 'Fasyankes'
        ];

        foreach ($datas as $data) {
            $mdSektorLb3 = new MdSektorLb3;
            $mdSektorLb3->user_id = 1;
            $mdSektorLb3->nama = $data;
            $mdSektorLb3->save();
        }
    }
}
