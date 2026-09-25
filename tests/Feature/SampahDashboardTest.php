<?php

namespace Tests\Feature;

use Database\Seeders\PontianakSampahSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SampahDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_pontianak_sample_data_is_consistent_and_idempotent(): void
    {
        $this->seed(PontianakSampahSampleSeeder::class);
        $this->seed(PontianakSampahSampleSeeder::class);

        $regencyId = DB::table('regencies')->where('name', 'Kota Pontianak')->value('id');

        $this->assertNotNull($regencyId);
        $this->assertSame(15, DB::table('data_sampahs')
            ->where('kabupaten_kota_id', $regencyId)
            ->whereBetween('tahun', [2022, 2026])
            ->count());
        $this->assertSame(5, DB::table('jumlah_penduduks')
            ->where('kabupaten_kota_id', $regencyId)
            ->whereBetween('tahun', [2022, 2026])
            ->count());

        $this->getJson("/api/public/sampah/regions/{$regencyId}?year=2026&from_year=2022&to_year=2026")
            ->assertOk()
            ->assertJsonPath('summary.daily_waste', 1500)
            ->assertJsonPath('summary.previous_daily_waste', 1400)
            ->assertJsonPath('summary.annual_waste', 547500)
            ->assertJsonPath('summary.previous_annual_waste', 511000)
            ->assertJsonPath('summary.population', 675000)
            ->assertJsonPath('summary.previous_population', 669000)
            ->assertJsonPath('summary.managed_waste', 121200)
            ->assertJsonPath('summary.unmanaged_waste', 426300)
            ->assertJsonCount(3, 'summary.categories')
            ->assertJsonPath('summary.categories.0.total', 300000)
            ->assertJsonPath('summary.categories.1.total', 239300)
            ->assertJsonPath('summary.categories.2.total', 8200)
            ->assertJsonPath('chart.values.0', 410000)
            ->assertJsonPath('chart.values.1', 430000)
            ->assertJsonPath('chart.values.2', 465000)
            ->assertJsonPath('chart.values.3', 511000)
            ->assertJsonPath('chart.values.4', 547500);
    }

    public function test_sampah_dashboard_aggregates_more_than_one_thousand_rows_without_serializing_them(): void
    {
        $now = now();
        $primaryRegionId = DB::table('regencies')->insertGetId(['name' => 'Kota Sampah', 'created_at' => $now, 'updated_at' => $now]);
        $secondaryRegionId = DB::table('regencies')->insertGetId(['name' => 'Kabupaten Sampah Lain', 'created_at' => $now, 'updated_at' => $now]);

        $organicId = DB::table('md_kategori_sampahs')->insertGetId([
            'nama' => 'Organik', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $inorganicId = DB::table('md_kategori_sampahs')->insertGetId([
            'nama' => 'Anorganik', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);
        $specificId = DB::table('md_kategori_sampahs')->insertGetId([
            'nama' => 'B3 / Spesifik', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('md_kategori_sampahs')->insert([
            'nama' => 'Organik', 'status_aktif' => '1', 'created_at' => $now, 'updated_at' => $now,
        ]);

        $rows = [];
        for ($index = 1; $index <= 1205; $index++) {
            if ($index <= 1000) {
                [$regionId, $categoryId, $value, $managed] = [$primaryRegionId, $organicId, 10, 6];
            } elseif ($index <= 1100) {
                [$regionId, $categoryId, $value, $managed] = [$primaryRegionId, $inorganicId, 20, 12];
            } elseif ($index <= 1105) {
                [$regionId, $categoryId, $value, $managed] = [$primaryRegionId, $specificId, 40, 10];
            } else {
                [$regionId, $categoryId, $value, $managed] = [$secondaryRegionId, $organicId, 1, 0];
            }

            $rows[] = [
                'kabupaten_kota_id' => $regionId,
                'kategori_sampah_id' => $categoryId,
                'nilai' => $value,
                'sampah_terkelola' => $managed,
                'tahun' => 2025,
                'tanggal_pendataan' => '2025-06-30',
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 250) as $chunk) {
            DB::table('data_sampahs')->insert($chunk);
        }

        DB::table('data_sampahs')->insert([
            $this->wasteRow($primaryRegionId, $organicId, 1000, 600, 2024, $now),
            $this->wasteRow($primaryRegionId, $inorganicId, 500, 300, 2024, $now),
            $this->wasteRow($primaryRegionId, $specificId, 50, 10, 2024, $now),
        ]);
        DB::table('jumlah_penduduks')->insert([
            ['kabupaten_kota_id' => $primaryRegionId, 'nilai' => 669000, 'tahun' => 2024, 'created_at' => $now, 'updated_at' => $now],
            ['kabupaten_kota_id' => $primaryRegionId, 'nilai' => 675000, 'tahun' => 2025, 'created_at' => $now, 'updated_at' => $now],
        ]);

        Cache::flush();

        $this->get('/program-aksi/sampah?year=2025')
            ->assertOk()
            ->assertSee('Kota Sampah')
            ->assertSee('Detail wilayah dimuat saat dibuka')
            ->assertDontSee('1208 raw records');

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->getJson("/api/public/sampah/regions/{$primaryRegionId}?year=2025&from_year=2021&to_year=2025");
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonPath('previous_year', 2024)
            ->assertJsonPath('summary.daily_waste', 33.42)
            ->assertJsonPath('summary.previous_daily_waste', 4.23)
            ->assertJsonPath('summary.annual_waste', 12200)
            ->assertJsonPath('summary.previous_annual_waste', 1550)
            ->assertJsonPath('summary.population', 675000)
            ->assertJsonPath('summary.previous_population', 669000)
            ->assertJsonPath('summary.managed_waste', 7250)
            ->assertJsonPath('summary.unmanaged_waste', 4950)
            ->assertJsonCount(3, 'summary.categories')
            ->assertJsonPath('summary.categories.0.total', 10000)
            ->assertJsonPath('summary.categories.1.total', 2000)
            ->assertJsonPath('summary.categories.2.total', 200)
            ->assertJsonPath('chart.labels.0', '2021')
            ->assertJsonPath('chart.labels.4', '2025')
            ->assertJsonPath('chart.values.3', 1550)
            ->assertJsonPath('chart.values.4', 12200);

        $this->assertLessThanOrEqual(5, $queryCount, 'The Sampah endpoint should use a fixed number of aggregate queries.');
        $this->assertLessThan(25000, strlen($response->getContent()), 'The endpoint must not serialize raw waste rows.');

        DB::flushQueryLog();
        $this->getJson("/api/public/sampah/regions/{$primaryRegionId}?year=2025&from_year=2021&to_year=2025")->assertOk();
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'The second regional request should be served from cache.');
    }

    public function test_sampah_region_endpoint_rejects_a_range_longer_than_five_years(): void
    {
        $regionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Validasi Sampah', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->getJson("/api/public/sampah/regions/{$regionId}?year=2025&from_year=2019&to_year=2025")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('from_year');
    }

    private function wasteRow(int $regionId, int $categoryId, float $value, float $managed, int $year, $now): array
    {
        return [
            'kabupaten_kota_id' => $regionId,
            'kategori_sampah_id' => $categoryId,
            'nilai' => $value,
            'sampah_terkelola' => $managed,
            'tahun' => $year,
            'tanggal_pendataan' => "{$year}-06-30",
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
