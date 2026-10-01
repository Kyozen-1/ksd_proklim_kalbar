<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MapDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_map_page_and_api_are_dynamic_and_filterable(): void
    {
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

        $this->get('/program-aksi/proklim?year=2026')
            ->assertOk()
            ->assertSee('/data-proklim?feature=proklim', false);

        $this->get('/data-proklim?feature=proklim')
            ->assertOk()
            ->assertSee("initialFeature: 'proklim'", false);

        $response = $this->getJson('/api/public/map/markers?'.http_build_query([
            'features' => ['proklim'],
            'bounds' => '108,-2,114,2',
        ]));

        $response->assertOk()
            ->assertJsonPath('count', 0)
            ->assertJsonPath('truncated', false)
            ->assertJsonCount(0, 'markers');

        $this->getJson('/api/public/map/markers?search=tidak-ada&bounds=108,-2,114,2')
            ->assertOk()
            ->assertJsonPath('count', 0)
            ->assertJsonCount(0, 'markers');
    }

    public function test_proklim_cms_coordinates_are_exposed_as_map_markers_and_details(): void
    {
        $now = now();
        $regencyId = DB::table('regencies')->insertGetId([
            'name' => 'Kabupaten Lokasi CMS',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $categoryId = DB::table('md_kategori_proklims')->insertGetId([
            'nama' => 'Utama',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $proklimId = DB::table('data_proklims')->insertGetId([
            'kabupaten_kota_id' => $regencyId,
            'kategori_proklim_id' => $categoryId,
            'nama' => 'Kampung Iklim CMS',
            'deskripsi' => 'Lokasi ini berasal langsung dari data CMS PROKLIM.',
            'alamat' => 'Desa Contoh, Kabupaten Lokasi CMS',
            'lat' => '-0.1251234',
            'lng' => '109.3759876',
            'tanggal_aktif' => '2026-06-30',
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $response = $this->getJson('/api/public/map/markers?'.http_build_query([
            'regency' => $regencyId,
            'features' => ['proklim'],
            'bounds' => '108,-2,114,2',
        ]));

        $response->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('markers.0.id', "proklim-{$proklimId}")
            ->assertJsonPath('markers.0.feature', 'proklim')
            ->assertJsonPath('markers.0.title', 'Kampung Iklim CMS')
            ->assertJsonPath('markers.0.category', 'Utama')
            ->assertJsonPath('markers.0.region', 'Kabupaten Lokasi CMS');

        $this->getJson("/api/public/map/markers/proklim-{$proklimId}")
            ->assertOk()
            ->assertJsonPath('feature_label', 'Proklim')
            ->assertJsonPath('title', 'Kampung Iklim CMS')
            ->assertJsonPath('address', 'Desa Contoh, Kabupaten Lokasi CMS')
            ->assertJsonPath('description', 'Lokasi ini berasal langsung dari data CMS PROKLIM.')
            ->assertJsonPath('latitude', -0.1251234)
            ->assertJsonPath('longitude', 109.3759876);
    }

    public function test_marker_endpoint_caps_large_viewports_at_five_hundred_points(): void
    {
        $regencyId = DB::table('regencies')->insertGetId([
            'name' => 'Kabupaten Uji Peta', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $now = now();
        $rows = [];

        foreach (range(1, 505) as $number) {
            $rows[] = [
                'kabupaten_kota_id' => $regencyId,
                'nama' => "Lokasi Uji {$number}",
                'alamat' => 'Alamat uji',
                'lat' => (string) (-0.5 + (($number % 100) * 0.001)),
                'lng' => (string) (109.0 + (($number % 100) * 0.001)),
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('data_proklims')->insert($chunk);
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

        $this->assertLessThanOrEqual(3, $queryCount, 'The marker API must use the data_proklims query only.');
        $this->assertLessThan(180000, strlen($response->getContent()), 'The marker API must return compact marker summaries.');
    }

    public function test_marker_endpoint_rejects_invalid_bounds(): void
    {
        $this->getJson('/api/public/map/markers?bounds=114,2,108,-2')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('bounds');
    }
}
