<?php

namespace Tests\Feature;

use Database\Seeders\KalimantanBaratLb3SampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Lb3DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_lazily_aggregates_more_than_two_thousand_regional_measurements(): void
    {
        $this->seed(KalimantanBaratLb3SampleSeeder::class);
        $this->seed(KalimantanBaratLb3SampleSeeder::class);

        $regencyId = DB::table('regencies')->where('name', 'Kota Pontianak')->value('id');

        $this->assertNotNull($regencyId);
        $this->assertSame(2520, DB::table('data_timbulan_lb3s')
            ->whereBetween('tahun', [2022, 2026])
            ->count());
        $this->assertSame(14, DB::table('data_timbulan_lb3s')
            ->distinct()
            ->count('kabupaten_kota_id'));
        $this->assertSame(180, DB::table('data_timbulan_lb3s')
            ->where('kabupaten_kota_id', $regencyId)
            ->whereBetween('tahun', [2022, 2026])
            ->count());

        $this->get('/program-aksi/lb3?year=2026')
            ->assertOk()
            ->assertSee('Kota Pontianak')
            ->assertSee('Detail wilayah dimuat saat dibuka')
            ->assertDontSee('Sumber:');

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->getJson("/api/public/lb3/regions/{$regencyId}?year=2026");
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonPath('region.name', 'Kota Pontianak')
            ->assertJsonPath('year', 2026)
            ->assertJsonPath('previous_year', 2025)
            ->assertJsonPath('summary.total', 1478)
            ->assertJsonPath('summary.previous_total', 1445)
            ->assertJsonCount(2, 'summary.sectors')
            ->assertJsonPath('summary.sectors.0.name', 'Industri')
            ->assertJsonPath('summary.sectors.0.total', 562.4)
            ->assertJsonPath('summary.sectors.0.previous_total', 551)
            ->assertJsonPath('summary.sectors.1.name', 'Fasyankes')
            ->assertJsonPath('summary.sectors.1.total', 325.6)
            ->assertJsonPath('summary.sectors.1.previous_total', 311.2);

        $this->assertLessThanOrEqual(5, $queryCount, 'The LB3 endpoint should use a fixed number of aggregate queries.');
        $this->assertLessThan(25000, strlen($response->getContent()), 'The endpoint must not serialize raw measurements.');

        DB::flushQueryLog();
        $this->getJson("/api/public/lb3/regions/{$regencyId}?year=2026")->assertOk();
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'The second regional request should be served from cache.');
    }

    public function test_region_endpoint_rejects_an_invalid_year(): void
    {
        $regionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Validasi LB3', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->getJson("/api/public/lb3/regions/{$regionId}?year=1999")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('year');
    }
}
