<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProklimDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_and_lazy_region_endpoint_handle_more_than_one_thousand_records(): void
    {
        $now = now();

        $primaryRegionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Uji Utama',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $secondaryRegionId = DB::table('regencies')->insertGetId([
            'name' => 'Kabupaten Uji Lain',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $primaryDistrictId = DB::table('districts')->insertGetId([
            'regency_id' => $primaryRegionId,
            'name' => 'Kecamatan Utama',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $secondaryDistrictId = DB::table('districts')->insertGetId([
            'regency_id' => $secondaryRegionId,
            'name' => 'Kecamatan Lain',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $categoryIds = collect(['Pratama', 'Madya', 'Utama', 'Trophy Utama'])
            ->map(fn ($name) => DB::table('md_kategori_proklims')->insertGetId([
                'nama' => $name,
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ]));

        $locations = [];
        for ($index = 1; $index <= 1205; $index++) {
            $primary = $index <= 1105;
            $locations[] = [
                'kabupaten_kota_id' => $primary ? $primaryRegionId : $secondaryRegionId,
                'kecamatan_id' => $primary ? $primaryDistrictId : $secondaryDistrictId,
                'kategori_proklim_id' => $categoryIds[($index - 1) % $categoryIds->count()],
                'nama' => sprintf('Lokasi Beban %04d', $index),
                'tanggal_aktif' => '2026-01-01',
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($locations, 250) as $chunk) {
            DB::table('data_proklims')->insert($chunk);
        }

        $carbonRows = [];
        $reductionRows = [];
        DB::table('data_proklims')->orderBy('id')->pluck('id')->each(function ($id) use (&$carbonRows, &$reductionRows, $now) {
            $carbonRows[] = ['data_proklim_id' => $id, 'nilai' => 2.5, 'tahun' => 2026, 'created_at' => $now, 'updated_at' => $now];
            $reductionRows[] = ['data_proklim_id' => $id, 'nilai' => 1.25, 'tahun' => 2026, 'created_at' => $now, 'updated_at' => $now];
        });

        foreach (array_chunk($carbonRows, 250) as $chunk) {
            DB::table('serapan_karbon_proklims')->insert($chunk);
        }
        foreach (array_chunk($reductionRows, 250) as $chunk) {
            DB::table('reduksi_emisi_proklims')->insert($chunk);
        }

        Cache::flush();

        $page = $this->get('/program-aksi/proklim?year=2026');
        $page->assertOk()
            ->assertSee('Kota Uji Utama')
            ->assertDontSee('Data ringkasan sampai tahun')
            ->assertDontSee('Lokasi Beban 0001');

        DB::flushQueryLog();
        DB::enableQueryLog();

        $response = $this->getJson("/api/public/proklim/regions/{$primaryRegionId}?year=2026");
        $queryCount = count(DB::getQueryLog());

        $response->assertOk()
            ->assertJsonPath('region.name', 'Kota Uji Utama')
            ->assertJsonPath('summary.total_locations', 1105)
            ->assertJsonPath('summary.locations_in_year', 1105)
            ->assertJsonPath('summary.carbon_absorption', 2762.5)
            ->assertJsonPath('summary.carbon_absorption_in_year', 2762.5)
            ->assertJsonPath('summary.emission_reduction', 1381.25)
            ->assertJsonPath('summary.emission_reduction_in_year', 1381.25)
            ->assertJsonPath('chart.labels.0', 'Kecamatan Utama')
            ->assertJsonPath('chart.values.0', 1105);

        $this->assertLessThanOrEqual(10, $queryCount, 'The lazy region response should use a bounded number of aggregate queries.');
        $this->assertLessThan(25000, strlen($response->getContent()), 'The endpoint must not serialize the 1,000+ raw location rows.');

        DB::flushQueryLog();
        $this->getJson("/api/public/proklim/regions/{$primaryRegionId}?year=2026")->assertOk();
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()), 'The second regional request should be served from cache.');
    }

    public function test_region_endpoint_rejects_an_invalid_year(): void
    {
        $regionId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Validasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->getJson("/api/public/proklim/regions/{$regionId}?year=1999")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('year');
    }
}
