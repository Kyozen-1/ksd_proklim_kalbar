<?php

namespace Tests\Feature;

use Database\Seeders\KalimantanBaratKualitasLingkunganSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KualitasLingkunganDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_aggregates_five_years_and_more_than_two_thousand_regional_measurements(): void
    {
        $this->seed(KalimantanBaratKualitasLingkunganSampleSeeder::class);
        $this->seed(KalimantanBaratKualitasLingkunganSampleSeeder::class);

        $regencyId = DB::table('regencies')->where('name', 'Kota Pontianak')->value('id');

        $this->assertNotNull($regencyId);
        $this->assertSame(2520, DB::table('data_kualitas_lingkungans')
            ->whereBetween('tahun', [2022, 2026])
            ->count());
        $this->assertSame(14, DB::table('data_kualitas_lingkungans')
            ->distinct()
            ->count('kabupaten_kota_id'));
        $this->assertSame(180, DB::table('data_kualitas_lingkungans')
            ->where('kabupaten_kota_id', $regencyId)
            ->whereBetween('tahun', [2022, 2026])
            ->count());

        $this->get('/program-aksi/kualitas-lingkungan?year=2026')
            ->assertOk()
            ->assertSee('Kota Pontianak')
            ->assertSee('Tren Skor IKLH')
            ->assertDontSee('Kategori Baik')
            ->assertDontSee('2520 raw records');

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->getJson("/api/public/kualitas-lingkungan/regions/{$regencyId}?year=2026&from_year=2022&to_year=2026");
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonCount(3, 'indexes')
            ->assertJsonPath('indexes.0.label', 'Kualitas Air')
            ->assertJsonPath('indexes.0.value', 53.45)
            ->assertJsonPath('indexes.0.previous_value', 51.2)
            ->assertJsonPath('indexes.0.measurement_count', 12)
            ->assertJsonPath('indexes.1.label', 'Kualitas Tutupan Lahan')
            ->assertJsonPath('indexes.1.value', 44.12)
            ->assertJsonPath('indexes.2.label', 'Kualitas Udara')
            ->assertJsonPath('indexes.2.value', 86.21)
            ->assertJsonPath('chart.labels.0', '2022')
            ->assertJsonPath('chart.labels.4', '2026')
            ->assertJsonPath('chart.series.0.data.0', 53)
            ->assertJsonPath('chart.series.0.data.4', 53.45)
            ->assertJsonPath('chart.series.1.data.1', 75)
            ->assertJsonPath('chart.series.2.data.3', 85.1)
            ->assertJsonPath('chart.series.2.data.4', 86.21);

        $this->assertLessThanOrEqual(5, $queryCount, 'The quality endpoint should use a fixed number of aggregate queries.');
        $this->assertLessThan(25000, strlen($response->getContent()), 'The endpoint must not serialize raw regional measurements.');

        DB::flushQueryLog();
        $this->getJson("/api/public/kualitas-lingkungan/regions/{$regencyId}?year=2026&from_year=2022&to_year=2026")->assertOk();
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'The second regional request should be served from cache.');
    }

    public function test_quality_region_endpoint_rejects_a_range_longer_than_five_years(): void
    {
        $regionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Validasi Kualitas', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->getJson("/api/public/kualitas-lingkungan/regions/{$regionId}?year=2026&from_year=2020&to_year=2026")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('from_year');
    }
}
