<?php

namespace App\Services;

use App\Models\Regency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class KualitasLingkunganDashboardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function dashboard(int $year): array
    {
        return Cache::remember("public:kualitas-lingkungan:dashboard:{$year}", self::CACHE_TTL_SECONDS, fn () => [
            'regions' => $this->regionHeaders($year),
        ]);
    }

    public function availableYears(): array
    {
        return Cache::remember('public:kualitas-lingkungan:years', self::CACHE_TTL_SECONDS, function () {
            return collect([now()->year])
                ->merge(DB::table('data_kualitas_lingkungans')->whereNotNull('tahun')->distinct()->pluck('tahun'))
                ->map(fn ($year) => (int) $year)
                ->filter(fn ($year) => $year >= 2000 && $year <= now()->year + 1)
                ->unique()
                ->sortDesc()
                ->values()
                ->all();
        });
    }

    public function regionDetail(Regency $regency, int $year, int $fromYear, int $toYear): array
    {
        return Cache::remember(
            "public:kualitas-lingkungan:region:{$regency->id}:{$year}:{$fromYear}:{$toYear}",
            self::CACHE_TTL_SECONDS,
            function () use ($regency, $year, $fromYear, $toYear) {
                $previousYear = $year - 1;
                $minimumYear = min($fromYear, $previousYear);
                $maximumYear = max($toYear, $year);
                $categories = DB::table('md_kategori_kualitas_lingkungans')
                    ->where('status_aktif', '1')
                    ->select('nama')
                    ->selectRaw('MIN(id) as id')
                    ->groupBy('nama')
                    ->orderByRaw('MIN(id)')
                    ->get();

                $scores = DB::table('data_kualitas_lingkungans as quality')
                    ->join('md_kategori_kualitas_lingkungans as categories', function ($join) {
                        $join->on('categories.id', '=', 'quality.kategori_kualitas_lingkungan_id')
                            ->where('categories.status_aktif', '=', '1');
                    })
                    ->where('quality.kabupaten_kota_id', $regency->id)
                    ->whereBetween('quality.tahun', [$minimumYear, $maximumYear])
                    ->select('categories.nama as category_name', 'quality.tahun')
                    ->selectRaw('ROUND(AVG(quality.nilai), 2) as score')
                    ->selectRaw('COUNT(*) as measurement_count')
                    ->groupBy('categories.nama', 'quality.tahun')
                    ->get();
                $scoresByCategory = $scores->groupBy('category_name');
                $trendYears = collect(range($fromYear, $toYear));

                $indexes = $categories->map(function ($category) use ($scoresByCategory, $year, $previousYear) {
                    $categoryScores = $scoresByCategory->get($category->nama, collect())->keyBy('tahun');

                    return [
                        'id' => $category->id,
                        'name' => $category->nama,
                        'label' => $this->indexLabel($category->nama),
                        'value' => (float) ($categoryScores[$year]->score ?? 0),
                        'previous_value' => (float) ($categoryScores[$previousYear]->score ?? 0),
                        'measurement_count' => (int) ($categoryScores[$year]->measurement_count ?? 0),
                    ];
                })->values();

                return [
                    'region' => ['id' => $regency->id, 'name' => $regency->name],
                    'year' => $year,
                    'previous_year' => $previousYear,
                    'indexes' => $indexes->all(),
                    'chart' => [
                        'from_year' => $fromYear,
                        'to_year' => $toYear,
                        'labels' => $trendYears->map(fn ($trendYear) => (string) $trendYear)->all(),
                        'series' => $indexes->map(function ($index) use ($scoresByCategory, $trendYears) {
                            $categoryScores = $scoresByCategory->get($index['name'], collect())->keyBy('tahun');

                            return [
                                'name' => $index['label'],
                                'data' => $trendYears
                                    ->map(fn ($trendYear) => (float) ($categoryScores[$trendYear]->score ?? 0))
                                    ->all(),
                            ];
                        })->all(),
                    ],
                ];
            }
        );
    }

    private function indexLabel(string $category): string
    {
        return match (mb_strtolower($category)) {
            'air' => 'Kualitas Air',
            'tutupan lahan' => 'Kualitas Tutupan Lahan',
            'udara' => 'Kualitas Udara',
            default => "Kualitas {$category}",
        };
    }

    private function regionHeaders(int $year): array
    {
        return DB::table('regencies')
            ->leftJoin('data_kualitas_lingkungans as quality', function ($join) use ($year) {
                $join->on('quality.kabupaten_kota_id', '=', 'regencies.id')
                    ->where('quality.tahun', '=', $year);
            })
            ->select('regencies.id', 'regencies.name', DB::raw('COUNT(quality.id) as data_count'))
            ->groupBy('regencies.id', 'regencies.name')
            ->orderBy('regencies.name')
            ->get()
            ->map(fn ($region) => [
                'id' => $region->id,
                'name' => $region->name,
                'data_count' => (int) $region->data_count,
            ])
            ->all();
    }
}
