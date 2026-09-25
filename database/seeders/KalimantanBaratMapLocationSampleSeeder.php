<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KalimantanBaratMapLocationSampleSeeder extends Seeder
{
    public function run(): void
    {
        $centres = [
            'Kabupaten Bengkayang' => [0.8209, 109.4777],
            'Kabupaten Kapuas Hulu' => [0.8356, 112.9378],
            'Kabupaten Kayong Utara' => [-1.0120, 110.0410],
            'Kabupaten Ketapang' => [-1.8591, 109.9719],
            'Kabupaten Kubu Raya' => [-0.3540, 109.2560],
            'Kabupaten Landak' => [0.4237, 109.7592],
            'Kabupaten Melawai' => [-0.7000, 111.6667],
            'Kabupaten Mempawah' => [0.3333, 109.1000],
            'Kabupaten Sambas' => [1.3614, 109.3099],
            'Kabupaten Sanggau' => [0.1193, 110.5973],
            'Kabupaten Sekadau' => [0.0349, 110.9507],
            'Kabupaten Sintang' => [0.0802, 111.4955],
            'Kota Pontianak' => [-0.0263, 109.3425],
            'Kota Singkawang' => [0.9060, 108.9872],
        ];
        $featureOffsets = [
            'proklim' => [-0.030, -0.030],
            'igrk' => [0.025, -0.018],
            'sampah' => [-0.012, 0.032],
            'kualitas-lingkungan' => [0.036, 0.024],
            'lb3' => [0.002, 0.050],
        ];
        $images = [
            'proklim' => '/frontend/img/default-slider-1.png',
            'igrk' => '/frontend/img/default-slider-1.png',
            'sampah' => '/frontend/img/default-slider-2.png',
            'kualitas-lingkungan' => '/frontend/img/default-slider-2.png',
            'lb3' => '/frontend/img/default-slider-2.png',
        ];
        $now = now();

        DB::transaction(function () use ($centres, $featureOffsets, $images, $now) {
            foreach (array_keys($centres) as $regionOffset => $regionName) {
                $coordinates = $centres[$regionName];
                $regencyId = DB::table('regencies')->where('name', $regionName)->value('id');
                if (!$regencyId) {
                    $regencyId = DB::table('regencies')->insertGetId([
                        'name' => $regionName,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                $shortName = str_replace(['Kabupaten ', 'Kota '], '', $regionName);
                foreach ($featureOffsets as $feature => [$latOffset, $lngOffset]) {
                    $payload = $this->payload($feature, $shortName, $regionOffset);
                    DB::table('map_locations')->updateOrInsert(
                        ['slug' => "sample-map-{$feature}-".str($shortName)->slug()],
                        [
                            'regency_id' => $regencyId,
                            'feature' => $feature,
                            'title' => $payload['title'],
                            'category' => $payload['category'],
                            'address' => "{$shortName}, {$regionName}, Kalimantan Barat",
                            'description' => $payload['description'],
                            'metric_label' => $payload['metric_label'],
                            'metric_value' => $payload['metric_value'],
                            'metric_unit' => $payload['metric_unit'],
                            'additional_info' => $payload['additional_info'],
                            'source_url' => 'https://lhk.kalbarprov.go.id/',
                            'image_url' => $images[$feature],
                            'latitude' => $coordinates[0] + $latOffset,
                            'longitude' => $coordinates[1] + $lngOffset,
                            'status_aktif' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }
            }
        });
    }

    private function payload(string $feature, string $region, int $offset): array
    {
        return match ($feature) {
            'proklim' => [
                'title' => "Kampung Iklim {$region}",
                'category' => ['Pratama', 'Utama', 'Lestari'][$offset % 3],
                'description' => 'Lokasi aksi adaptasi dan mitigasi iklim berbasis masyarakat.',
                'metric_label' => 'Lokasi Proklim', 'metric_value' => 1, 'metric_unit' => 'titik',
                'additional_info' => 'Aktif',
            ],
            'igrk' => [
                'title' => "Inventaris Emisi {$region}",
                'category' => 'IGRK',
                'description' => 'Titik representatif inventarisasi gas rumah kaca kabupaten/kota.',
                'metric_label' => 'Emisi Tahunan', 'metric_value' => 125000 + ($offset * 17500), 'metric_unit' => 'tCO₂e',
                'additional_info' => 'Pemutakhiran 2026',
            ],
            'sampah' => [
                'title' => "Bank Sampah {$region}",
                'category' => 'Bank Sampah',
                'description' => 'Lokasi layanan pengumpulan dan pengelolaan sampah wilayah.',
                'metric_label' => 'Sampah Terkelola', 'metric_value' => 45 + ($offset * 3.5), 'metric_unit' => 'ton/hari',
                'additional_info' => (1 + ($offset % 5)).' Bank Sampah',
            ],
            'kualitas-lingkungan' => [
                'title' => "Pos Pantau Lingkungan {$region}",
                'category' => 'Kualitas Lingkungan',
                'description' => 'Lokasi representatif pemantauan indeks air, udara, dan tutupan lahan.',
                'metric_label' => 'Skor IKLH', 'metric_value' => 62 + ($offset * 1.4), 'metric_unit' => 'indeks',
                'additional_info' => 'Air · Udara · Tutupan Lahan',
            ],
            default => [
                'title' => "Pemantauan LB3 {$region}",
                'category' => 'Industri & Fasyankes',
                'description' => 'Lokasi representatif pemantauan timbulan limbah B3.',
                'metric_label' => 'Timbulan LB3', 'metric_value' => 180 + ($offset * 22.5), 'metric_unit' => 'ton/tahun',
                'additional_info' => 'Industri dan Fasyankes',
            ],
        };
    }
}
