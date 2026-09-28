<?php

namespace Tests\Feature;

use App\Services\LandingDashboardStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LandingPageCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_keeps_its_design_fallback_when_the_cms_is_empty(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Bersama Menjaga Bumi dari')
            ->assertSee('Dampak Nyata Lapangan Kalimantan Barat')
            ->assertSee('Pembinaan &amp; Pengurangan Timbunan Sampah', false)
            ->assertSee('Website Resmi DLHK Kalimantan Barat');
    }

    public function test_homepage_renders_repeatable_active_cms_records_and_hides_inactive_records(): void
    {
        $heroSection = $this->createMasterSection('Hero');
        $functionSection = $this->createMasterSection('Fungsi Item');
        $statSection = $this->createMasterSection('Statistik Item');
        $newsSection = $this->createMasterSection('Kabar Berita');
        $inactiveMaster = $this->createMasterSection('Beranda Hero', '0');

        $this->createLandingItem($heroSection, 'test_hero_1', -20, [
            'eyebrow' => 'Hero dari CMS',
            'title' => 'Judul Hero Dinamis Pertama',
            'subtitle' => 'Slide Satu',
            'description' => 'Deskripsi hero yang dikelola melalui CMS.',
            'button_text' => 'Tombol Hero',
            'button_link' => '/tentang',
        ]);
        $this->createLandingItem($heroSection, 'test_hero_2', -19, [
            'title' => 'Judul Hero Dinamis Kedua',
            'subtitle' => 'Slide Dua',
        ]);
        $this->createLandingItem($heroSection, 'test_hero_inactive', -30, [
            'title' => 'Hero Item Tidak Aktif',
        ], '0');
        $this->createLandingItem($inactiveMaster, 'test_inactive_master', -40, [
            'title' => 'Hero Master Tidak Aktif',
        ]);

        $this->createLandingItem($functionSection, 'test_function_1', -10, [
            'title' => 'Fungsi Dinamis dari CMS',
            'description' => 'Isi fungsi dapat diurutkan dan ditambah dari dashboard admin.',
        ]);

        $this->createLandingItem($statSection, 'test_stat_1', -10, [
            'label' => 'Indikator CMS',
            'value' => '12345',
            'unit' => 'Unit',
            'meta' => 'Diperbarui hari ini',
            'icon' => 'fa-leaf',
        ]);

        $this->createLandingItem($newsSection, 'test_news_header', -10, [
            'eyebrow' => 'Label Berita CMS',
            'title' => 'Judul Berita dari CMS',
            'button_text' => 'Semua Kabar',
            'button_link' => '/berita',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Judul Hero Dinamis Pertama')
            ->assertSee('Judul Hero Dinamis Kedua')
            ->assertSee('Fungsi Dinamis dari CMS')
            ->assertSee('Indikator CMS')
            ->assertSee('12.345')
            ->assertSee('Judul Berita dari CMS')
            ->assertSee('Semua Kabar')
            ->assertDontSee('Hero Item Tidak Aktif')
            ->assertDontSee('Hero Master Tidak Aktif');
    }

    public function test_default_homepage_statistics_are_aggregated_from_operational_cms_data_except_tps(): void
    {
        $year = now()->year;
        $now = now();

        $currentProklimId = DB::table('data_proklims')->insertGetId([
            'nama' => 'PROKLIM Tahun Ini',
            'tanggal_aktif' => "{$year}-06-01",
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $previousProklimId = DB::table('data_proklims')->insertGetId([
            'nama' => 'PROKLIM Tahun Sebelumnya',
            'tanggal_aktif' => ($year - 1).'-06-01',
            'status_aktif' => '1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $inactiveProklimId = DB::table('data_proklims')->insertGetId([
            'nama' => 'PROKLIM Tidak Aktif',
            'tanggal_aktif' => "{$year}-06-01",
            'status_aktif' => '0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('reduksi_emisi_proklims')->insert([
            [
                'data_proklim_id' => $currentProklimId,
                'nilai' => 100,
                'tahun' => $year,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'data_proklim_id' => $previousProklimId,
                'nilai' => 50,
                'tahun' => $year - 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'data_proklim_id' => $inactiveProklimId,
                'nilai' => 999,
                'tahun' => $year,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('data_emisis')->insert([
            [
                'nilai' => 200,
                'tahun' => $year,
                'status_aktif' => '0',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nilai' => 300,
                'tahun' => $year - 1,
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nilai' => 999,
                'tahun' => $year + 1,
                'status_aktif' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $statSection = $this->createMasterSection('Statistik Item');
        $this->createLandingItem($statSection, 'operational_stat_proklim', 1, [
            'label' => 'Kampung Iklim Aktif',
            'value' => '9999',
            'meta' => 'Nilai manual tidak digunakan',
            'icon' => 'fa-house',
        ]);
        $this->createLandingItem($statSection, 'operational_stat_reduction', 2, [
            'label' => 'Reduksi Gas Emisi',
            'value' => '9999',
            'unit' => 'tCO2e/th',
            'meta' => 'Nilai manual tidak digunakan',
            'icon' => 'fa-wind',
        ]);
        $this->createLandingItem($statSection, 'operational_stat_emission', 3, [
            'label' => 'Total Emisi',
            'value' => '9999',
            'unit' => 'tCO2e/th',
            'meta' => 'Nilai manual tidak digunakan',
            'icon' => 'fa-wind',
        ]);
        $this->createLandingItem($statSection, 'manual_stat_tps', 4, [
            'label' => 'Total TPS Aktif',
            'value' => '77',
            'unit' => 'Unit',
            'meta' => 'TPS tetap manual',
            'icon' => 'fa-trash-can',
        ]);

        $summary = app(LandingDashboardStatsService::class)->summary($year);

        $this->assertSame(['total' => 2, 'year_total' => 1], $summary['proklim']);
        $this->assertSame(['total' => 150.0, 'year_total' => 100.0], $summary['emission_reduction']);
        $this->assertSame(['total' => 500.0, 'year_total' => 200.0], $summary['emission']);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('Kampung Iklim Aktif')
            ->assertSeeText("{$year}: 1 Titik")
            ->assertSeeText('Reduksi Gas Emisi')
            ->assertSeeText("{$year}: 100 tCO2e")
            ->assertSeeText('Total Emisi')
            ->assertSeeText("{$year}: 200 tCO2e")
            ->assertSeeText('Total TPS Aktif')
            ->assertSeeText('77')
            ->assertSeeText('TPS tetap manual')
            ->assertDontSeeText('Nilai manual tidak digunakan');
    }

    private function createMasterSection(string $name, string $status = '1'): int
    {
        return DB::table('md_section_landing_pages')->insertGetId([
            'user_id' => null,
            'nama' => $name,
            'status_aktif' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createLandingItem(
        int $sectionId,
        string $key,
        int $sortOrder,
        array $content,
        string $status = '1'
    ): void {
        DB::table('landing_page_sections')->insert([
            'user_id' => null,
            'section_key' => $key,
            'section_id' => $sectionId,
            'sort_order' => $sortOrder,
            'status_aktif' => $status,
            'content' => json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
