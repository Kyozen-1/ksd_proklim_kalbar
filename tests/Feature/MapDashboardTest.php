<?php

namespace Tests\Feature;

use Database\Seeders\KalimantanBaratMapLocationSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MapDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_map_page_and_api_are_dynamic_and_filterable(): void
    {
        $this->seed(KalimantanBaratMapLocationSampleSeeder::class);
        $this->seed(KalimantanBaratMapLocationSampleSeeder::class);

        $this->assertSame(70, DB::table('map_locations')->count());
        $this->assertSame(14, DB::table('map_locations')->distinct()->count('regency_id'));
        $this->assertSame(5, DB::table('map_locations')->distinct()->count('feature'));

        $this->get('/data-proklim')
            ->assertOk()
            ->assertSee('Peta persebaran data lingkungan Kalimantan Barat')
            ->assertSee('Semua Kategori')
            ->assertSee('Kategori Data')
            ->assertSee('Jenis Peta')
            ->assertSee('Terrain')
            ->assertSee('switchBaseMap', false)
            ->assertSee('window.environmentMap', false)
            ->assertDontSee('Nama Desa / Kelurahan');

        $pontianakId = DB::table('regencies')->where('name', 'Kota Pontianak')->value('id');
        $response = $this->getJson('/api/public/map/markers?'.http_build_query([
            'regency' => $pontianakId,
            'features' => ['sampah'],
            'bounds' => '108,-2,114,2',
        ]));

        $response->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('truncated', false)
            ->assertJsonPath('markers.0.feature', 'sampah')
            ->assertJsonPath('markers.0.region', 'Kota Pontianak')
            ->assertJsonPath('markers.0.title', 'Bank Sampah Pontianak');

        $markerId = $response->json('markers.0.id');
        $this->getJson("/api/public/map/markers/{$markerId}")
            ->assertOk()
            ->assertJsonPath('feature_label', 'Sampah')
            ->assertJsonPath('category', 'Bank Sampah')
            ->assertJsonPath('metric.label', 'Sampah Terkelola')
            ->assertJsonPath('metric.unit', 'ton/hari')
            ->assertJsonPath('source_url', 'https://lhk.kalbarprov.go.id/');

        $this->getJson('/api/public/map/markers?search=tidak-ada&bounds=108,-2,114,2')
            ->assertOk()
            ->assertJsonPath('count', 0)
            ->assertJsonCount(0, 'markers');
    }

    public function test_marker_endpoint_caps_large_viewports_at_five_hundred_points(): void
    {
        $regencyId = DB::table('regencies')->insertGetId([
            'name' => 'Kabupaten Uji Peta', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $now = now();
        $rows = [];

        foreach (range(1, 1005) as $number) {
            $rows[] = [
                'regency_id' => $regencyId,
                'slug' => "load-map-{$number}",
                'feature' => 'proklim',
                'title' => "Lokasi Uji {$number}",
                'latitude' => -0.5 + (($number % 100) * 0.001),
                'longitude' => 109.0 + (($number % 100) * 0.001),
                'status_aktif' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 400) as $chunk) {
            DB::table('map_locations')->insert($chunk);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();
        $response = $this->getJson('/api/public/map/markers?features[]=proklim&bounds=108,-2,114,2&limit=500');
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonPath('count', 500)
            ->assertJsonPath('truncated', true)
            ->assertJsonPath('limit', 500)
            ->assertJsonCount(500, 'markers');

        $this->assertLessThanOrEqual(4, $queryCount, 'The marker API must keep a fixed query count.');
        $this->assertLessThan(180000, strlen($response->getContent()), 'The marker API must return compact marker summaries.');
    }

    public function test_marker_endpoint_rejects_invalid_bounds(): void
    {
        $this->getJson('/api/public/map/markers?bounds=114,2,108,-2')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('bounds');
    }
}
