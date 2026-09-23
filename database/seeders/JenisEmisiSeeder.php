<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MdSektorUtamaEmisi;
use App\Models\MdJenisEmisi;

class JenisEmisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'sektor_utama' => 'Folu (Kehutanan & Lahan)',
                'jenis_emisi' => [
                    [
                        'nama' => 'Total Emisi',
                        'jenis_perhitungan' => 'tambah'
                    ],
                    [
                        'nama' => 'Faktor Serapan',
                        'jenis_perhitungan' => 'kurang'
                    ]
                ]
            ],
            [
                'sektor_utama' => 'Energi & Transportasi',
                'jenis_emisi' => [
                    [
                        'nama' => 'Emisi Bahan Bakar',
                        'jenis_perhitungan' => 'tambah'
                    ],
                    [
                        'nama' => 'Listrik',
                        'jenis_perhitungan' => 'tambah'
                    ]
                ]
            ],
            [
                'sektor_utama' => 'Pengolahan Limbah',
                'jenis_emisi' => [
                    [
                        'nama' => 'Emisi Sampah',
                        'jenis_perhitungan' => 'tambah'
                    ],
                    [
                        'nama' => 'Emisi Air Limbah',
                        'jenis_perhitungan' => 'tambah'
                    ]
                ]
            ],
            [
                'sektor_utama' => 'Pertanian & Peternakan',
                'jenis_emisi' => [
                    [
                        'nama' => 'Emisi Peternakan',
                        'jenis_perhitungan' => 'tambah'
                    ],
                    [
                        'nama' => 'Pupuk Kimia & Sawah',
                        'jenis_perhitungan' => 'tambah'
                    ]
                ]
            ],
            [
                'sektor_utama' => 'IPPU (Industri)',
                'jenis_emisi' => [
                    [
                        'nama' => 'Emisi IPPU',
                        'jenis_perhitungan' => 'tambah'
                    ]
                ]
            ],
        ];

        foreach ($datas as $data) {
            $getMdSektorUtamaEmisi = MdSektorUtamaEmisi::where('nama', 'like', '%'.$data['sektor_utama'].'%')->first();
            if($getMdSektorUtamaEmisi)
            {
                foreach ($data['jenis_emisi'] as $jenis_emisi) {
                    $mdJenisEmisi = new MdJenisEmisi;
                    $mdJenisEmisi->sektor_utama_emisi_id = $getMdSektorUtamaEmisi->id;
                    $mdJenisEmisi->nama = $jenis_emisi['nama'];
                    $mdJenisEmisi->jenis_perhitungan = $jenis_emisi['jenis_perhitungan'];
                    $mdJenisEmisi->save();
                }
            }
        }
    }
}
