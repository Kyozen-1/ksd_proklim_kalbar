<?php

namespace Tests\Feature;

use App\Http\Controllers\Backend\JumlahPendudukController;
use App\Http\Controllers\Backend\SampahController;
use App\Http\Controllers\Backend\TargetPenurunanEmisiController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CmsPublicDashboardSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_target_emissions_are_saved_per_region_and_refresh_the_public_igrk_data(): void
    {
        $now = now();
        $pontianakId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Pontianak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $singkawangId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Singkawang',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->getJson("/api/public/igrk/regions/{$pontianakId}?year=2026")
            ->assertOk()
            ->assertJsonPath('summary.target_reduction_in_year', 0);

        $controller = app(TargetPenurunanEmisiController::class);
        $pontianakResponse = $controller->store(Request::create('/', 'POST', [
            'kabupaten_kota_id' => Crypt::encryptString($pontianakId),
            'tahun' => 2026,
            'nilai' => 600000,
        ]));
        $singkawangResponse = $controller->store(Request::create('/', 'POST', [
            'kabupaten_kota_id' => Crypt::encryptString($singkawangId),
            'tahun' => 2026,
            'nilai' => 250000,
        ]));

        $this->assertArrayHasKey('success', $pontianakResponse->getData(true));
        $this->assertArrayHasKey('success', $singkawangResponse->getData(true));
        $this->assertDatabaseCount('target_penurunan_emisis', 2);
        $this->assertDatabaseHas('target_penurunan_emisis', [
            'kabupaten_kota_id' => $pontianakId,
            'tahun' => 2026,
            'nilai' => 600000,
        ]);
        $this->assertDatabaseHas('target_penurunan_emisis', [
            'kabupaten_kota_id' => $singkawangId,
            'tahun' => 2026,
            'nilai' => 250000,
        ]);

        $this->getJson("/api/public/igrk/regions/{$pontianakId}?year=2026")
            ->assertOk()
            ->assertJsonPath('summary.target_reduction_in_year', 600000);
        $this->getJson("/api/public/igrk/regions/{$singkawangId}?year=2026")
            ->assertOk()
            ->assertJsonPath('summary.target_reduction_in_year', 250000);
    }

    public function test_new_waste_and_population_data_are_active_and_refresh_the_public_sampah_data(): void
    {
        $now = now();
        $pontianakId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Pontianak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $singkawangId = DB::table('regencies')->insertGetId([
            'name' => 'Kota Singkawang',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $categoryId = DB::table('md_kategori_sampahs')->insertGetId([
            'nama' => 'Organik',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->getJson("/api/public/sampah/regions/{$pontianakId}?year=2026&from_year=2022&to_year=2026")
            ->assertOk()
            ->assertJsonPath('summary.annual_waste', 0)
            ->assertJsonPath('summary.population', 0);

        $wasteResponse = app(SampahController::class)->store(Request::create('/', 'POST', [
            'kabupaten_kota_id' => Crypt::encryptString($pontianakId),
            'kategori_sampah_id' => Crypt::encryptString($categoryId),
            'tahun' => [2026],
            'nilai' => [3650],
            'sampah_terkelola' => [1000],
            'tanggal_pendataan' => ['2026-06-30'],
        ]));

        $populationController = app(JumlahPendudukController::class);
        $pontianakPopulationResponse = $populationController->store(Request::create('/', 'POST', [
            'kabupaten_kota_id' => Crypt::encryptString($pontianakId),
            'tahun' => 2026,
            'nilai' => 10000,
        ]));
        $singkawangPopulationResponse = $populationController->store(Request::create('/', 'POST', [
            'kabupaten_kota_id' => Crypt::encryptString($singkawangId),
            'tahun' => 2026,
            'nilai' => 20000,
        ]));

        $this->assertArrayHasKey('success', $wasteResponse->getData(true));
        $this->assertArrayHasKey('success', $pontianakPopulationResponse->getData(true));
        $this->assertArrayHasKey('success', $singkawangPopulationResponse->getData(true));
        $this->assertDatabaseHas('data_sampahs', [
            'kabupaten_kota_id' => $pontianakId,
            'kategori_sampah_id' => $categoryId,
            'tahun' => 2026,
            'status_aktif' => '1',
        ]);
        $this->assertDatabaseCount('jumlah_penduduks', 2);

        $this->getJson("/api/public/sampah/regions/{$pontianakId}?year=2026&from_year=2022&to_year=2026")
            ->assertOk()
            ->assertJsonPath('summary.daily_waste', 10)
            ->assertJsonPath('summary.annual_waste', 3650)
            ->assertJsonPath('summary.population', 10000)
            ->assertJsonPath('summary.managed_waste', 1000)
            ->assertJsonPath('summary.unmanaged_waste', 2650);
    }

    public function test_public_igrk_and_sampah_queries_include_inactive_records_and_master_data(): void
    {
        $now = now();
        $regencyId = DB::table('regencies')->insertGetId([
            'name' => 'Kabupaten Data Lama',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $sectorId = DB::table('md_sektor_utama_emisis')->insertGetId([
            'nama' => 'Sektor Tidak Aktif',
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $emissionTypeId = DB::table('md_jenis_emisis')->insertGetId([
            'sektor_utama_emisi_id' => $sectorId,
            'nama' => 'Jenis Tidak Aktif',
            'jenis_perhitungan' => 'tambah',
            'satuan' => 'tco2e',
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('data_emisis')->insert([
            'kabupaten_kota_id' => $regencyId,
            'jenis_emisi_id' => $emissionTypeId,
            'nilai' => 125,
            'tahun' => 2026,
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $wasteCategoryId = DB::table('md_kategori_sampahs')->insertGetId([
            'nama' => 'Kategori Tidak Aktif',
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('data_sampahs')->insert([
            'kabupaten_kota_id' => $regencyId,
            'kategori_sampah_id' => $wasteCategoryId,
            'nilai' => 365,
            'sampah_terkelola' => 100,
            'tahun' => 2026,
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->getJson("/api/public/igrk/regions/{$regencyId}?year=2026")
            ->assertOk()
            ->assertJsonPath('summary.net_emission_in_year', 125)
            ->assertJsonPath('sectors.0.name', 'Sektor Tidak Aktif')
            ->assertJsonPath('sectors.0.types.0.name', 'Jenis Tidak Aktif');

        $this->getJson("/api/public/sampah/regions/{$regencyId}?year=2026&from_year=2022&to_year=2026")
            ->assertOk()
            ->assertJsonPath('summary.daily_waste', 1)
            ->assertJsonPath('summary.annual_waste', 365)
            ->assertJsonPath('summary.categories.0.name', 'Kategori Tidak Aktif');
    }
}
