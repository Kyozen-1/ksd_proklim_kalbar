<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AnggotaPelaksana;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Faq;
use App\Models\Kegiatan;
use App\Models\LandingPageSection;
use App\Models\MapLocation;
use App\Models\PivotGambarBerita;
use App\Models\PivotGambarKegiatan;
use App\Models\Regency;
use App\Models\Village;
use App\Services\ProklimDashboardService;
use App\Services\IgrkDashboardService;
use App\Services\KualitasLingkunganDashboardService;
use App\Services\Lb3DashboardService;
use App\Services\MapDashboardService;
use App\Services\SampahDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

    public function proklim(Request $request, ProklimDashboardService $dashboardService)
    {
        $years = $dashboardService->availableYears();
        $requestedYear = $request->integer('year');
        $year = in_array($requestedYear, $years, true) ? $requestedYear : ($years[0] ?? now()->year);
        $dashboard = $dashboardService->dashboard($year);

        return view('frontend.pages.proklim', compact('dashboard', 'year', 'years'));
    }

    public function proklimRegion(
        Request $request,
        Regency $regency,
        ProklimDashboardService $dashboardService
    ): JsonResponse {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
        ]);

        return response()
            ->json($dashboardService->regionDetail($regency, (int) $validated['year']))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
    }

    public function igrk(Request $request, IgrkDashboardService $dashboardService)
    {
        $years = $dashboardService->availableYears();
        $requestedYear = $request->integer('year');
        $year = in_array($requestedYear, $years, true) ? $requestedYear : ($years[0] ?? now()->year);
        $dashboard = $dashboardService->dashboard($year);

        return view('frontend.pages.igrk', compact('dashboard', 'year', 'years'));
    }

    public function igrkRegion(
        Request $request,
        Regency $regency,
        IgrkDashboardService $dashboardService
    ): JsonResponse {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
        ]);

        return response()
            ->json($dashboardService->regionDetail($regency, (int) $validated['year']))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
    }

    public function sampah(Request $request, SampahDashboardService $dashboardService)
    {
        $years = $dashboardService->availableYears();
        $requestedYear = $request->integer('year');
        $year = in_array($requestedYear, $years, true) ? $requestedYear : ($years[0] ?? now()->year);
        $dashboard = $dashboardService->dashboard($year);
        $minimumChartYear = min(min($years ?: [$year]), max(2000, $year - 4));
        $maximumChartYear = max(max($years ?: [$year]), $year);
        $chartYears = range($minimumChartYear, $maximumChartYear);

        return view('frontend.pages.sampah', compact('dashboard', 'year', 'years', 'chartYears'));
    }

    public function sampahRegion(
        Request $request,
        Regency $regency,
        SampahDashboardService $dashboardService
    ): JsonResponse {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            'from_year' => ['nullable', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            'to_year' => ['nullable', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
        ]);

        $year = (int) $validated['year'];
        $fromYear = (int) ($validated['from_year'] ?? max(2000, $year - 4));
        $toYear = (int) ($validated['to_year'] ?? $year);

        if ($fromYear > $toYear || $toYear - $fromYear > 4) {
            throw ValidationException::withMessages([
                'from_year' => 'Rentang grafik harus berurutan dan maksimal lima tahun.',
            ]);
        }

        return response()
            ->json($dashboardService->regionDetail($regency, $year, $fromYear, $toYear))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
    }

    public function kualitasLingkungan(Request $request, KualitasLingkunganDashboardService $dashboardService)
    {
        $years = $dashboardService->availableYears();
        $requestedYear = $request->integer('year');
        $year = in_array($requestedYear, $years, true) ? $requestedYear : ($years[0] ?? now()->year);
        $dashboard = $dashboardService->dashboard($year);
        $minimumChartYear = min(min($years ?: [$year]), max(2000, $year - 4));
        $maximumChartYear = max(max($years ?: [$year]), $year);
        $chartYears = range($minimumChartYear, $maximumChartYear);

        return view('frontend.pages.kualitas_lingkungan', compact('dashboard', 'year', 'years', 'chartYears'));
    }

    public function kualitasLingkunganRegion(
        Request $request,
        Regency $regency,
        KualitasLingkunganDashboardService $dashboardService
    ): JsonResponse {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            'from_year' => ['nullable', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            'to_year' => ['nullable', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
        ]);

        $year = (int) $validated['year'];
        $fromYear = (int) ($validated['from_year'] ?? max(2000, $year - 4));
        $toYear = (int) ($validated['to_year'] ?? $year);

        if ($fromYear > $toYear || $toYear - $fromYear > 4) {
            throw ValidationException::withMessages([
                'from_year' => 'Rentang grafik harus berurutan dan maksimal lima tahun.',
            ]);
        }

        return response()
            ->json($dashboardService->regionDetail($regency, $year, $fromYear, $toYear))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
    }

    public function lb3(Request $request, Lb3DashboardService $dashboardService)
    {
        $years = $dashboardService->availableYears();
        $requestedYear = $request->integer('year');
        $year = in_array($requestedYear, $years, true) ? $requestedYear : ($years[0] ?? now()->year);
        $dashboard = $dashboardService->dashboard($year);

        return view('frontend.pages.lb3', compact('dashboard', 'year', 'years'));
    }

    public function lb3Region(
        Request $request,
        Regency $regency,
        Lb3DashboardService $dashboardService
    ): JsonResponse {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
        ]);

        return response()
            ->json($dashboardService->regionDetail($regency, (int) $validated['year']))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
    }

    public function data(MapDashboardService $dashboardService)
    {
        return view('frontend.pages.data', ['mapConfig' => $dashboardService->pageConfig()]);
    }

    public function mapMarkers(Request $request, MapDashboardService $dashboardService): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'regency' => ['nullable', 'integer', 'exists:regencies,id'],
            'features' => ['nullable', 'array', 'max:5'],
            'features.*' => ['string', 'in:proklim,igrk,sampah,kualitas-lingkungan,lb3'],
            'bounds' => ['nullable', 'string', 'max:100'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:500'],
        ]);

        if (!empty($validated['bounds'])) {
            $bounds = array_map('floatval', explode(',', $validated['bounds']));
            if (count($bounds) !== 4 || $bounds[0] >= $bounds[2] || $bounds[1] >= $bounds[3]) {
                throw ValidationException::withMessages(['bounds' => 'Batas peta tidak valid.']);
            }
            $validated['bounds'] = $bounds;
        }

        return response()
            ->json($dashboardService->markers($validated))
            ->header('Cache-Control', 'public, max-age=60, stale-while-revalidate=30');
    }

    public function mapMarker(MapLocation $mapLocation, MapDashboardService $dashboardService): JsonResponse
    {
        return response()
            ->json($dashboardService->detail($mapLocation))
            ->header('Cache-Control', 'public, max-age=300, stale-while-revalidate=60');
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
