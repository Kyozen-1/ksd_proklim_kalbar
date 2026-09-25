<?php

namespace App\Services;

use App\Models\Regency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SampahDashboardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function dashboard(int $year): array
    {
        return Cache::remember("public:sampah:dashboard:{$year}", self::CACHE_TTL_SECONDS, fn () => [
            'regions' => $this->regionHeaders($year),
        ]);
    }

    public function availableYears(): array
    {
        return Cache::remember('public:sampah:years', self::CACHE_TTL_SECONDS, function () {
            return collect([now()->year])
                ->merge(DB::table('data_sampahs')->whereNotNull('tahun')->distinct()->pluck('tahun'))
                ->merge(DB::table('jumlah_penduduks')->whereNotNull('tahun')->distinct()->pluck('tahun'))
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
            "public:sampah:region:{$regency->id}:{$year}:{$fromYear}:{$toYear}",
            self::CACHE_TTL_SECONDS,
            function () use ($regency, $year, $fromYear, $toYear) {
                $previousYear = $year - 1;
                $categoryRows = DB::table('md_kategori_sampahs as categories')
                    ->leftJoin('data_sampahs as waste', function ($join) use ($regency, $year, $previousYear) {
                        $join->on('waste.kategori_sampah_id', '=', 'categories.id')
                            ->where('waste.kabupaten_kota_id', '=', $regency->id)
                            ->where('waste.status_aktif', '=', '1')
                            ->whereIn('waste.tahun', [$year, $previousYear]);
                    })
                    ->where('categories.status_aktif', '1')
                    ->select('categories.nama')
                    ->selectRaw('MIN(categories.id) as id')
                    ->selectRaw(
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.nilai ELSE 0 END), 0) as year_total, '.
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.nilai ELSE 0 END), 0) as previous_total, '.
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.sampah_terkelola ELSE 0 END), 0) as managed_total, '.
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.sampah_terkelola ELSE 0 END), 0) as previous_managed_total',
                        [$year, $previousYear, $year, $previousYear]
                    )
                    ->groupBy('categories.nama')
                    ->orderByRaw('MIN(categories.id)')
                    ->get();

                $annualWaste = (float) $categoryRows->sum('year_total');
                $previousAnnualWaste = (float) $categoryRows->sum('previous_total');
                $managedWaste = (float) $categoryRows->sum('managed_total');
                $previousManagedWaste = (float) $categoryRows->sum('previous_managed_total');
                $population = DB::table('jumlah_penduduks')
                    ->where('kabupaten_kota_id', $regency->id)
                    ->whereIn('tahun', [$year, $previousYear])
                    ->selectRaw(
                        'COALESCE(SUM(CASE WHEN tahun = ? THEN nilai ELSE 0 END), 0) as year_total, '.
                        'COALESCE(SUM(CASE WHEN tahun = ? THEN nilai ELSE 0 END), 0) as previous_total',
                        [$year, $previousYear]
                    )
                    ->first();

                $trendTotals = DB::table('data_sampahs')
                    ->where('kabupaten_kota_id', $regency->id)
                    ->where('status_aktif', '1')
                    ->whereBetween('tahun', [$fromYear, $toYear])
                    ->select('tahun')
                    ->selectRaw('COALESCE(SUM(nilai), 0) as total')
                    ->groupBy('tahun')
                    ->pluck('total', 'tahun');
                $trendYears = collect(range($fromYear, $toYear));

                return [
                    'region' => ['id' => $regency->id, 'name' => $regency->name],
                    'year' => $year,
                    'previous_year' => $previousYear,
                    'summary' => [
                        'daily_waste' => round($annualWaste / $this->daysInYear($year), 2),
                        'previous_daily_waste' => round($previousAnnualWaste / $this->daysInYear($previousYear), 2),
                        'annual_waste' => $annualWaste,
                        'previous_annual_waste' => $previousAnnualWaste,
                        'population' => (float) ($population->year_total ?? 0),
                        'previous_population' => (float) ($population->previous_total ?? 0),
                        'managed_waste' => $managedWaste,
                        'previous_managed_waste' => $previousManagedWaste,
                        'unmanaged_waste' => max(0, $annualWaste - $managedWaste),
                        'previous_unmanaged_waste' => max(0, $previousAnnualWaste - $previousManagedWaste),
                        'categories' => $categoryRows->map(fn ($category) => [
                            'id' => $category->id,
                            'name' => $category->nama,
                            'total' => (float) $category->year_total,
                            'previous_total' => (float) $category->previous_total,
                        ])->all(),
                    ],
                    'chart' => [
                        'from_year' => $fromYear,
                        'to_year' => $toYear,
                        'labels' => $trendYears->map(fn ($trendYear) => (string) $trendYear)->all(),
                        'values' => $trendYears->map(fn ($trendYear) => (float) ($trendTotals[$trendYear] ?? 0))->all(),
                    ],
                ];
            }
        );
    }

    private function daysInYear(int $year): int
    {
        return (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) ? 366 : 365;
    }

    private function regionHeaders(int $year): array
    {
        return DB::table('regencies')
            ->leftJoin('data_sampahs', function ($join) use ($year) {
                $join->on('data_sampahs.kabupaten_kota_id', '=', 'regencies.id')
                    ->where('data_sampahs.status_aktif', '=', '1')
                    ->where('data_sampahs.tahun', '=', $year);
            })
            ->select('regencies.id', 'regencies.name', DB::raw('COUNT(data_sampahs.id) as data_count'))
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
