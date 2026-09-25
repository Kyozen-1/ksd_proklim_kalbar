<?php

namespace Tests\Feature;

use Database\Seeders\PontianakIgrkSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class IgrkDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_pontianak_sample_data_has_verifiable_totals_and_is_idempotent(): void
    {
        $this->seed(PontianakIgrkSampleSeeder::class);
        $this->seed(PontianakIgrkSampleSeeder::class);

        $regencyId = DB::table('regencies')->where('name', 'Kota Pontianak')->value('id');

        $this->assertNotNull($regencyId);
        $this->assertSame(9, DB::table('data_emisis')
            ->where('kabupaten_kota_id', $regencyId)
            ->where('tahun', 2026)
            ->where('tanggal_pendataan', '2026-06-30')
            ->count());
        $this->assertSame(1, DB::table('target_penurunan_emisis')
            ->where('kabupaten_kota_id', $regencyId)
            ->where('tahun', 2026)
            ->count());

        $this->getJson("/api/public/igrk/regions/{$regencyId}?year=2026")
            ->assertOk()
            ->assertJsonPath('summary.net_emission', 450000)
            ->assertJsonPath('summary.net_emission_in_year', 450000)
            ->assertJsonPath('summary.target_reduction_in_year', 600000)
            ->assertJsonPath('summary.achieved_reduction_in_year', 30000)
            ->assertJsonPath('summary.performance.label', 'Perlu Perhatian')
            ->assertJsonPath('summary.performance.progress', 5)
            ->assertJsonPath('chart.values.0', 50000)
            ->assertJsonPath('chart.values.1', 150000)
            ->assertJsonPath('chart.values.2', 100000)
            ->assertJsonPath('chart.values.3', 60000)
            ->assertJsonPath('chart.values.4', 90000);
    }

    public function test_igrk_dashboard_aggregates_more_than_one_thousand_rows_without_serializing_them(): void
    {
        $now = now();
        $primaryRegionId = DB::table('regencies')->insertGetId(['name' => 'Kota Emisi', 'created_at' => $now, 'updated_at' => $now]);
        $secondaryRegionId = DB::table('regencies')->insertGetId(['name' => 'Kabupaten Emisi Lain', 'created_at' => $now, 'updated_at' => $now]);

        $foluSectorId = DB::table('md_sektor_utama_emisis')->insertGetId([
            'nama' => 'FOLU (Kehutanan & Lahan)', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $energySectorId = DB::table('md_sektor_utama_emisis')->insertGetId([
            'nama' => 'Energi & Transportasi', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $emissionTypeId = DB::table('md_jenis_emisis')->insertGetId([
            'sektor_utama_emisi_id' => $foluSectorId,
            'nama' => 'Total Emisi',
            'jenis_perhitungan' => 'tambah',
            'satuan' => 'tco2e',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $absorptionTypeId = DB::table('md_jenis_emisis')->insertGetId([
            'sektor_utama_emisi_id' => $foluSectorId,
            'nama' => 'Faktor Serapan',
            'jenis_perhitungan' => 'kurang',
            'satuan' => 'tco2e',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $fuelTypeId = DB::table('md_jenis_emisis')->insertGetId([
            'sektor_utama_emisi_id' => $energySectorId,
            'nama' => 'Bahan Bakar',
            'jenis_perhitungan' => 'tambah',
            'satuan' => 'kl',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rows = [];
        for ($index = 1; $index <= 1205; $index++) {
            if ($index <= 1000) {
                $regionId = $primaryRegionId;
                $typeId = $emissionTypeId;
                $value = 10;
            } elseif ($index <= 1100) {
                $regionId = $primaryRegionId;
                $typeId = $absorptionTypeId;
                $value = 2;
            } elseif ($index <= 1105) {
                $regionId = $primaryRegionId;
                $typeId = $fuelTypeId;
                $value = 100;
            } else {
                $regionId = $secondaryRegionId;
                $typeId = $emissionTypeId;
                $value = 1;
            }

            $rows[] = [
                'kabupaten_kota_id' => $regionId,
                'jenis_emisi_id' => $typeId,
                'nilai' => $value,
                'tahun' => 2026,
                'tanggal_pendataan' => '2026-06-01',
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 250) as $chunk) {
            DB::table('data_emisis')->insert($chunk);
        }

        DB::table('target_penurunan_emisis')->insert([
            'kabupaten_kota_id' => $primaryRegionId,
            'nilai' => 250,
            'tahun' => 2026,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Cache::flush();

        $this->get('/program-aksi/igrk?year=2026')
            ->assertOk()
            ->assertSee('Kota Emisi')
            ->assertDontSee('1205 raw records');

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->getJson("/api/public/igrk/regions/{$primaryRegionId}?year=2026");
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonPath('summary.net_emission', 9800)
            ->assertJsonPath('summary.net_emission_in_year', 9800)
            ->assertJsonPath('summary.target_reduction_in_year', 250)
            ->assertJsonPath('summary.achieved_reduction_in_year', 200)
            ->assertJsonPath('summary.performance.label', 'Dalam Pemantauan')
            ->assertJsonPath('summary.performance.progress', 80)
            ->assertJsonPath('chart.labels.0', 'FOLU (Kehutanan & Lahan)')
            ->assertJsonPath('chart.values.0', 9800)
            ->assertJsonPath('chart.labels.1', 'Energi & Transportasi')
            ->assertJsonPath('chart.values.1', 0);

        $this->assertLessThanOrEqual(5, $queryCount, 'The IGRK region endpoint should use a fixed number of aggregate queries.');
        $this->assertLessThan(25000, strlen($response->getContent()), 'The endpoint must not serialize raw IGRK rows.');

        DB::flushQueryLog();
        $this->getJson("/api/public/igrk/regions/{$primaryRegionId}?year=2026")->assertOk();
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'The second IGRK regional request should be served from cache.');
    }

    public function test_igrk_region_endpoint_rejects_an_invalid_year(): void
    {
        $regionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Validasi IGRK', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->getJson("/api/public/igrk/regions/{$regionId}?year=1999")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('year');
    }
}
