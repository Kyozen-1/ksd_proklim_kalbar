<?php

namespace App\Services;

use App\Models\Regency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Lb3DashboardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function dashboard(int $year): array
    {
        return Cache::remember("public:lb3:dashboard:{$year}", self::CACHE_TTL_SECONDS, fn () => [
            'regions' => $this->regionHeaders($year),
        ]);
    }

    public function availableYears(): array
    {
        return Cache::remember('public:lb3:years', self::CACHE_TTL_SECONDS, function () {
            return collect([now()->year])
                ->merge(DB::table('data_timbulan_lb3s')->whereNotNull('tahun')->distinct()->pluck('tahun'))
                ->map(fn ($year) => (int) $year)
                ->filter(fn ($year) => $year >= 2000 && $year <= now()->year + 1)
                ->unique()
                ->sortDesc()
                ->values()
                ->all();
        });
    }

    public function regionDetail(Regency $regency, int $year): array
    {
        return Cache::remember(
            "public:lb3:region:{$regency->id}:{$year}",
            self::CACHE_TTL_SECONDS,
            function () use ($regency, $year) {
                $previousYear = $year - 1;
                $sectorRows = DB::table('md_sektor_lb3s as sectors')
                    ->leftJoin('data_timbulan_lb3s as waste', function ($join) use ($regency, $year, $previousYear) {
                        $join->on('waste.sektor_lb3_id', '=', 'sectors.id')
                            ->where('waste.kabupaten_kota_id', '=', $regency->id)
                            ->whereIn('waste.tahun', [$year, $previousYear]);
                    })
                    ->where('sectors.status_aktif', '1')
                    ->select('sectors.nama')
                    ->selectRaw('MIN(sectors.id) as id')
                    ->selectRaw(
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.nilai ELSE 0 END), 0) as year_total, '.
                        'COALESCE(SUM(CASE WHEN waste.tahun = ? THEN waste.nilai ELSE 0 END), 0) as previous_total',
                        [$year, $previousYear]
                    )
                    ->groupBy('sectors.nama')
                    ->orderByRaw('MIN(sectors.id)')
                    ->get();

                return [
                    'region' => ['id' => $regency->id, 'name' => $regency->name],
                    'year' => $year,
                    'previous_year' => $previousYear,
                    'summary' => [
                        'total' => round((float) $sectorRows->sum('year_total'), 2),
                        'previous_total' => round((float) $sectorRows->sum('previous_total'), 2),
                        'sectors' => $sectorRows
                            ->filter(fn ($sector) => in_array(mb_strtolower($sector->nama), ['industri', 'fasyankes'], true))
                            ->map(fn ($sector) => [
                                'id' => $sector->id,
                                'name' => $sector->nama,
                                'total' => round((float) $sector->year_total, 2),
                                'previous_total' => round((float) $sector->previous_total, 2),
                            ])
                            ->values()
                            ->all(),
                    ],
                ];
            }
        );
    }

    private function regionHeaders(int $year): array
    {
        return DB::table('regencies')
            ->leftJoin('data_timbulan_lb3s as waste', function ($join) use ($year) {
                $join->on('waste.kabupaten_kota_id', '=', 'regencies.id')
                    ->where('waste.tahun', '=', $year);
            })
            ->select('regencies.id', 'regencies.name', DB::raw('COUNT(waste.id) as data_count'))
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
