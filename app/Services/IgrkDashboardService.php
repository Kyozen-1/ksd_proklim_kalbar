<?php

namespace App\Services;

use App\Models\Regency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IgrkDashboardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function dashboard(int $year): array
    {
        return Cache::remember("public:igrk:dashboard:{$year}", self::CACHE_TTL_SECONDS, fn () => [
            'regions' => $this->regionHeaders($year),
        ]);
    }

    public function availableYears(): array
    {
        return Cache::remember('public:igrk:years', self::CACHE_TTL_SECONDS, function () {
            return collect([now()->year])
                ->merge(DB::table('data_emisis')->whereNotNull('tahun')->distinct()->pluck('tahun'))
                ->merge(DB::table('target_penurunan_emisis')->whereNotNull('tahun')->distinct()->pluck('tahun'))
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
            "public:igrk:region:{$regency->id}:{$year}",
            self::CACHE_TTL_SECONDS,
            function () use ($regency, $year) {
                $rows = DB::table('md_sektor_utama_emisis as sectors')
                    ->leftJoin('md_jenis_emisis as types', function ($join) {
                        $join->on('types.sektor_utama_emisi_id', '=', 'sectors.id')
                            ->where('types.status_aktif', '=', '1');
                    })
                    ->leftJoin('data_emisis as emissions', function ($join) use ($regency, $year) {
                        $join->on('emissions.jenis_emisi_id', '=', 'types.id')
                            ->where('emissions.kabupaten_kota_id', '=', $regency->id)
                            ->where('emissions.status_aktif', '=', '1')
                            ->where('emissions.tahun', '<=', $year);
                    })
                    ->where('sectors.status_aktif', '1')
                    ->select(
                        'sectors.id as sector_id',
                        'sectors.nama as sector_name',
                        'types.id as type_id',
                        'types.nama as type_name',
                        'types.jenis_perhitungan',
                        'types.satuan'
                    )
                    ->selectRaw(
                        'COALESCE(SUM(emissions.nilai), 0) as total, '.
                        'COALESCE(SUM(CASE WHEN emissions.tahun = ? THEN emissions.nilai ELSE 0 END), 0) as year_total',
                        [$year]
                    )
                    ->groupBy(
                        'sectors.id',
                        'sectors.nama',
                        'types.id',
                        'types.nama',
                        'types.jenis_perhitungan',
                        'types.satuan'
                    )
                    ->orderBy('sectors.id')
                    ->orderBy('types.id')
                    ->get();

                $sectors = $rows
                    ->groupBy('sector_id')
                    ->map(function ($sectorRows) {
                        $first = $sectorRows->first();
                        $types = $sectorRows
                            ->filter(fn ($row) => $row->type_id !== null)
                            ->map(fn ($row) => [
                                'id' => $row->type_id,
                                'name' => $row->type_name,
                                'calculation' => $row->jenis_perhitungan,
                                'unit' => $row->satuan,
                                'total' => (float) $row->total,
                                'year_total' => (float) $row->year_total,
                            ])
                            ->values();

                        return [
                            'id' => $first->sector_id,
                            'name' => $first->sector_name,
                            'types' => $types->all(),
                            'chart_total' => (float) $types
                                ->where('unit', 'tco2e')
                                ->sum(fn ($type) => ($type['calculation'] === 'kurang' ? -1 : 1) * $type['year_total']),
                        ];
                    })
                    ->values();

                $allTypes = $sectors->flatMap(fn ($sector) => $sector['types']);
                $netEmission = (float) $allTypes
                    ->where('unit', 'tco2e')
                    ->sum(fn ($type) => ($type['calculation'] === 'kurang' ? -1 : 1) * $type['total']);
                $netEmissionInYear = (float) $allTypes
                    ->where('unit', 'tco2e')
                    ->sum(fn ($type) => ($type['calculation'] === 'kurang' ? -1 : 1) * $type['year_total']);
                $reductionInYear = (float) $allTypes
                    ->where('unit', 'tco2e')
                    ->where('calculation', 'kurang')
                    ->sum('year_total');

                $target = DB::table('target_penurunan_emisis')
                    ->where('kabupaten_kota_id', $regency->id)
                    ->where('tahun', '<=', $year)
                    ->selectRaw(
                        'COALESCE(SUM(nilai), 0) as total, '.
                        'COALESCE(SUM(CASE WHEN tahun = ? THEN nilai ELSE 0 END), 0) as year_total',
                        [$year]
                    )
                    ->first();
                $targetInYear = (float) ($target->year_total ?? 0);
                $performance = $this->performanceStatus($reductionInYear, $targetInYear);

                return [
                    'region' => [
                        'id' => $regency->id,
                        'name' => $regency->name,
                    ],
                    'year' => $year,
                    'summary' => [
                        'net_emission' => $netEmission,
                        'net_emission_in_year' => $netEmissionInYear,
                        'target_reduction' => (float) ($target->total ?? 0),
                        'target_reduction_in_year' => $targetInYear,
                        'achieved_reduction_in_year' => $reductionInYear,
                        'performance' => $performance,
                    ],
                    'sectors' => $sectors->all(),
                    'chart' => [
                        'labels' => $sectors->pluck('name')->all(),
                        'values' => $sectors->pluck('chart_total')->all(),
                    ],
                ];
            }
        );
    }

    private function performanceStatus(float $achieved, float $target): array
    {
        if ($target <= 0) {
            return ['label' => 'Belum Ada Target', 'tone' => 'neutral', 'progress' => 0];
        }

        $progress = min(100, max(0, ($achieved / $target) * 100));

        if ($achieved >= $target) {
            return ['label' => 'Target Tercapai', 'tone' => 'good', 'progress' => round($progress, 2)];
        }

        if ($progress >= 75) {
            return ['label' => 'Dalam Pemantauan', 'tone' => 'warning', 'progress' => round($progress, 2)];
        }

        return ['label' => 'Perlu Perhatian', 'tone' => 'danger', 'progress' => round($progress, 2)];
    }

    private function regionHeaders(int $year): array
    {
        return DB::table('regencies')
            ->leftJoin('data_emisis', function ($join) use ($year) {
                $join->on('data_emisis.kabupaten_kota_id', '=', 'regencies.id')
                    ->where('data_emisis.status_aktif', '=', '1')
                    ->where('data_emisis.tahun', '<=', $year);
            })
            ->select('regencies.id', 'regencies.name', DB::raw('COUNT(data_emisis.id) as data_count'))
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
