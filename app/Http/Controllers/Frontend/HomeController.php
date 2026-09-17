<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AnggotaPelaksana;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Faq;
use App\Models\Kegiatan;
use App\Models\LandingPageSection;
use App\Models\PivotGambarBerita;
use App\Models\PivotGambarKegiatan;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function index()
    {
        $landingMetrics = $this->landingMetrics();
        $landingSections = $this->landingSections();
        $homeHero = $this->firstLandingContent($landingSections, ['home_hero', 'hero', 'slider', 'beranda_hero']);
        $homeFunction = $this->firstLandingContent($landingSections, ['home_tugas_fungsi', 'tugas_fungsi', 'pslb3pp_tugas_fungsi']);
        $homeIspu = $this->firstLandingContent($landingSections, ['home_ispu', 'ispu', 'akses_data']);
        $homeRegulation = $this->firstLandingContent($landingSections, ['home_regulasi', 'regulasi_banner', 'akses_data_terbuka']);
        $homeOfficial = $this->firstLandingContent($landingSections, ['home_dlhk', 'dlhk_website', 'website_resmi']);
        $homeVisitor = $this->firstLandingContent($landingSections, ['home_visitor', 'visitor_counter', 'kunjungi_website']);
        $kampungIklimCount = Village::count();

        $stats = [
            [
                'label' => 'Kampung Iklim Aktif',
                'value' => $this->displayMetric($kampungIklimCount),
                'unit' => '',
                'meta' => '2026: '.$this->displayMetric($this->metricValue($landingMetrics, ['kampung_iklim_2026', 'kampung_iklim_tahun_ini', 'lokasi_2026'], 0)).' Titik',
                'icon' => 'fa-house',
            ],
            [
                'label' => 'Reduksi Gas Emisi',
                'value' => $this->displayMetric($this->metricValue($landingMetrics, ['reduksi_gas_emisi', 'penurunan_emisi'], 0)),
                'unit' => 'tCO2e/th',
                'meta' => '2026: '.$this->displayMetric($this->metricValue($landingMetrics, ['reduksi_gas_emisi_2026', 'penurunan_emisi_2026'], 0)).' tCO2e',
                'icon' => 'fa-wind',
            ],
            [
                'label' => 'Total Emisi',
                'value' => $this->displayMetric($this->metricValue($landingMetrics, ['total_emisi', 'emisi'], 0)),
                'unit' => 'tCO2e/th',
                'meta' => '2026: '.$this->displayMetric($this->metricValue($landingMetrics, ['total_emisi_2026', 'emisi_2026'], 0)).' tCO2e',
                'icon' => 'fa-wind',
            ],
            [
                'label' => 'Total TPS Aktif',
                'value' => $this->displayMetric($this->metricValue($landingMetrics, ['total_tps_aktif', 'tps_aktif', 'total_tps'], 0)),
                'unit' => 'Unit',
                'meta' => '2026: '.$this->displayMetric($this->metricValue($landingMetrics, ['total_tps_aktif_2026', 'tps_aktif_2026', 'total_tps_2026'], 0)).' Unit',
                'icon' => 'fa-trash-can',
            ],
        ];

        $latestNews = $this->newsQuery()
            ->take(3)
            ->get();

        return view('frontend.pages.home', compact(
            'stats',
            'latestNews',
            'homeHero',
            'homeFunction',
            'homeIspu',
            'homeRegulation',
            'homeOfficial',
            'homeVisitor'
        ));
    }

    public function about()
    {
        return $this->pslb3pp();
    }

    public function edukasi()
    {
        return view('frontend.pages.edukasi');
    }

    public function featureDevelopment(string $feature)
    {
        $features = [
            'proklim' => [
                'name' => 'PROKLIM',
                'description' => 'Informasi Program Kampung Iklim sedang kami siapkan agar dapat disajikan secara lengkap dan mudah diakses.',
            ],
            'igrk' => [
                'name' => 'IGRK',
                'description' => 'Informasi Inventaris Gas Rumah Kaca sedang dalam proses pengembangan dan penyempurnaan data.',
            ],
            'sampah' => [
                'name' => 'Pengelolaan Sampah',
                'description' => 'Informasi dan layanan pengelolaan sampah sedang kami kembangkan untuk melayani masyarakat dengan lebih baik.',
            ],
            'kualitas-lingkungan' => [
                'name' => 'Kualitas Lingkungan',
                'description' => 'Informasi kualitas lingkungan sedang dalam tahap pengembangan dan akan tersedia pada pembaruan berikutnya.',
            ],
            'lb3' => [
                'name' => 'Limbah B3',
                'description' => 'Informasi Limbah Bahan Berbahaya dan Beracun sedang kami siapkan dan sempurnakan.',
            ],
        ];

        abort_unless(isset($features[$feature]), 404);

        return view('frontend.pages.feature_development', [
            'featureName' => $features[$feature]['name'],
            'featureDescription' => $features[$feature]['description'],
        ]);
    }

    public function data()
    {
        $regencies = Regency::orderBy('name')->get();
        $locations = Village::query()
            ->join('districts', 'villages.district_id', '=', 'districts.id')
            ->join('regencies', 'districts.regency_id', '=', 'regencies.id')
            ->select([
                'villages.id',
                'villages.name as village_name',
                'districts.name as district_name',
                'regencies.name as regency_name',
            ])
            ->orderBy('regencies.name')
            ->orderBy('districts.name')
            ->orderBy('villages.name')
            ->paginate(15);

        return view('frontend.pages.data', compact('locations', 'regencies'));
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function pslb3pp()
    {
        $landingSections = $this->landingSections();
        $profile = $this->firstLandingContent($landingSections, ['pslb3pp_profile', 'tentang_pslb3pp', 'about_pslb3pp']);
        $definition = $this->firstLandingContent($landingSections, ['pslb3pp_definition', 'definisi_bidang', 'peran_pslb3pp']);
        $function = $this->firstLandingContent($landingSections, ['pslb3pp_tugas_fungsi', 'tugas_fungsi']);

        $kegiatans = $this->activityQuery()
            ->take(6)
            ->get();

        $anggotaPelaksanas = AnggotaPelaksana::with('jabatan')
            ->statusAktif()
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.pages.about', compact('kegiatans', 'anggotaPelaksanas', 'profile', 'definition', 'function'));
    }

    public function regulasi()
    {
        $dokumens = Dokumen::statusAktif()
            ->whereIn('kategori', ['undang_undang', 'peraturan_daerah', 'panduan'])
            ->latest()
            ->paginate(10);

        return view('frontend.pages.regulasi', compact('dokumens'));
    }

    public function berita()
    {
        $beritas = $this->newsQuery()
            ->paginate(9);

        return view('frontend.pages.berita', compact('beritas'));
    }

    public function beritaDetail($id)
    {
        $berita = $this->newsQuery()->findOrFail($id);

        return view('frontend.pages.berita_detail', compact('berita'));
    }

    public function galeri()
    {
        $kegiatans = $this->activityQuery()
            ->paginate(9);

        return view('frontend.pages.galeri', compact('kegiatans'));
    }

    public function faq()
    {
        $faqs = Faq::statusAktif()
            ->latest()
            ->get();

        return view('frontend.pages.faq', compact('faqs'));
    }

    public function laporan()
    {
        $dokumens = Dokumen::statusAktif()
            ->where('kategori', 'laporan')
            ->latest()
            ->paginate(10);

        return view('frontend.pages.laporan', compact('dokumens'));
    }

    public function aksiLingkungan()
    {
        $kegiatans = $this->activityQuery()
            ->paginate(9);

        return view('frontend.pages.aksi_lingkungan', compact('kegiatans'));
    }

    public function aksiLingkunganDetail($id)
    {
        $kegiatan = $this->activityQuery()->findOrFail($id);
        $relatedKegiatans = $this->activityQuery()
            ->where('id', '!=', $kegiatan->id)
            ->take(3)
            ->get();

        return view('frontend.pages.aksi_lingkungan_detail', compact('kegiatan', 'relatedKegiatans'));
    }

    public function beritaImage($id)
    {
        $gambar = PivotGambarBerita::findOrFail($id);

        if (!$gambar->image_path || !Storage::disk('minio')->exists($gambar->image_path)) {
            abort(404);
        }

        return Storage::disk('minio')->response($gambar->image_path);
    }

    public function kegiatanImage($id)
    {
        $gambar = PivotGambarKegiatan::findOrFail($id);

        if (!$gambar->image_path || !Storage::disk('minio')->exists($gambar->image_path)) {
            abort(404);
        }

        return Storage::disk('minio')->response($gambar->image_path);
    }

    public function dokumenFile($id)
    {
        $dokumen = Dokumen::statusAktif()->findOrFail($id);

        if (!$dokumen->path || !Storage::disk('minio')->exists($dokumen->path)) {
            abort(404);
        }

        return Storage::disk('minio')->response($dokumen->path);
    }

    public function anggotaImage($id)
    {
        $anggota = AnggotaPelaksana::findOrFail($id);

        if (!$anggota->foto || !Storage::disk('minio')->exists($anggota->foto)) {
            abort(404);
        }

        return Storage::disk('minio')->response($anggota->foto);
    }

    public function landingImage($id, string $field = 'image')
    {
        $section = LandingPageSection::statusAktif()->findOrFail($id);
        $path = $section->content[$field] ?? null;

        if (!$path || !Storage::disk('minio')->exists($path)) {
            abort(404);
        }

        return Storage::disk('minio')->response($path);
    }

    private function newsQuery()
    {
        return Berita::with('pivot_gambar_berita')
            ->statusAktif()
            ->latest();
    }

    private function activityQuery()
    {
        return Kegiatan::with(['pivot_gambar_kegiatan', 'kabupaten_kota'])
            ->statusAktif()
            ->latest('tanggal')
            ->latest();
    }

    private function landingMetrics(): array
    {
        return $this->landingSections()
            ->pluck('content')
            ->filter()
            ->reduce(function (array $metrics, array $content) {
                foreach ($content as $key => $value) {
                    if ($value !== null && $value !== '') {
                        $metrics[$key] = $value;
                    }
                }

                return $metrics;
            }, []);
    }

    private function landingSections()
    {
        return LandingPageSection::with('section')
            ->statusAktif()
            ->orderBy('sort_order')
            ->get()
            ->map(function (LandingPageSection $landingSection) {
                $landingSection->lookup_keys = collect([
                    $landingSection->section_key,
                    $landingSection->section?->nama,
                ])
                    ->filter()
                    ->map(fn ($key) => $this->normalizeLandingKey($key))
                    ->unique()
                    ->values()
                    ->all();

                return $landingSection;
            });
    }

    private function firstLandingContent($sections, array $keys): array
    {
        $normalizedKeys = collect($keys)
            ->map(fn ($key) => $this->normalizeLandingKey($key))
            ->all();

        $section = $sections->first(function (LandingPageSection $section) use ($normalizedKeys) {
            return (bool) array_intersect($section->lookup_keys ?? [], $normalizedKeys);
        });

        if (!$section) {
            return [];
        }

        $content = $section->content ?? [];
        $content['_id'] = $section->id;

        if (!empty($content['image'])) {
            $content['image_url'] = route('frontend.landing.image', ['id' => $section->id, 'field' => 'image']);
        }

        return $content;
    }

    private function normalizeLandingKey(?string $key): string
    {
        return str($key ?? '')
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', '_')
            ->trim('_')
            ->toString();
    }

    private function metricValue(array $metrics, array $keys, $default = 0)
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $metrics) && $metrics[$key] !== null && $metrics[$key] !== '') {
                return $metrics[$key];
            }
        }

        return $default;
    }

    private function displayMetric($value): string
    {
        if ($value === null || $value === '') {
            return '0';
        }

        if (is_string($value) && (str_contains($value, '.') || str_contains($value, ','))) {
            return $value;
        }

        if (is_numeric($value)) {
            return number_format((float) $value, 0, ',', '.');
        }

        return (string) $value;
    }
}
