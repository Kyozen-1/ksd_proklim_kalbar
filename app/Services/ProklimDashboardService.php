<?php

namespace App\Services;

use App\Models\DataProklim;
use App\Models\MdKategoriProklim;
use App\Models\Regency;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProklimDashboardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function dashboard(int $year): array
    {
        return Cache::remember("public:proklim:dashboard:{$year}", self::CACHE_TTL_SECONDS, function () use ($year) {
            return [
                'regions' => $this->regionHeaders($year),
            ];
        });
    }

    public function availableYears(): array
    {
        return Cache::remember('public:proklim:years', self::CACHE_TTL_SECONDS, function () {
            $years = collect([now()->year]);

            $yearExpression = DB::connection()->getDriverName() === 'sqlite'
                ? "CAST(strftime('%Y', tanggal_aktif) AS INTEGER)"
                : 'YEAR(tanggal_aktif)';

            DataProklim::query()
                ->whereNotNull('tanggal_aktif')
                ->selectRaw("{$yearExpression} as active_year")
                ->distinct()
                ->pluck('active_year')
                ->each(fn ($year) => $years->push((int) $year));

            foreach (['serapan_karbon_proklims', 'reduksi_emisi_proklims'] as $table) {
                DB::table($table)
                    ->whereNotNull('tahun')
                    ->distinct()
                    ->pluck('tahun')
                    ->each(fn ($year) => $years->push((int) $year));
            }

            return $years
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
            "public:proklim:region:{$regency->id}:{$year}",
            self::CACHE_TTL_SECONDS,
            function () use ($regency, $year) {
                $base = $this->activeLocations($year)
                    ->where('kabupaten_kota_id', $regency->id);
                $categoryAggregates = (clone $base)
                    ->select('kategori_proklim_id')
                    ->selectRaw(
                        'COUNT(*) as total, SUM(CASE WHEN tanggal_aktif >= ? AND tanggal_aktif <= ? THEN 1 ELSE 0 END) as year_total',
                        ["{$year}-01-01", "{$year}-12-31"]
                    )
                    ->groupBy('kategori_proklim_id')
                    ->get();
                $categoryCounts = $categoryAggregates->pluck('total', 'kategori_proklim_id');
                $categoryYearCounts = $categoryAggregates->pluck('year_total', 'kategori_proklim_id');

                $districts = DB::table('districts')
                    ->leftJoin('data_proklims', function ($join) use ($year) {
                        $join->on('data_proklims.kecamatan_id', '=', 'districts.id')
                            ->where('data_proklims.status_aktif', '=', '1')
                            ->whereDate('data_proklims.tanggal_aktif', '>=', "{$year}-01-01")
                            ->whereDate('data_proklims.tanggal_aktif', '<=', "{$year}-12-31");
                    })
                    ->where('districts.regency_id', $regency->id)
                    ->select('districts.id', 'districts.name', DB::raw('COUNT(data_proklims.id) as total'))
                    ->groupBy('districts.id', 'districts.name')
                    ->orderBy('districts.name')
                    ->get()
                    ->map(fn ($district) => [
                        'id' => $district->id,
                        'name' => $district->name,
                        'total' => (int) $district->total,
                    ])
                    ->values();

                $locationStats = (clone $base)
                    ->selectRaw(
                        'COUNT(*) as total_locations, '.
                        'SUM(CASE WHEN tanggal_aktif >= ? AND tanggal_aktif <= ? THEN 1 ELSE 0 END) as locations_in_year, '.
                        'MAX(updated_at) as updated_at',
                        ["{$year}-01-01", "{$year}-12-31"]
                    )
                    ->first();
                $carbon = $this->environmentalTotals('serapan_karbon_proklims', $year, $regency->id);
                $emission = $this->environmentalTotals('reduksi_emisi_proklims', $year, $regency->id);
                $totalLocations = (int) ($locationStats->total_locations ?? 0);

                return [
                    'region' => [
                        'id' => $regency->id,
                        'name' => $regency->name,
                        'status' => $totalLocations > 0 ? 'Aktif' : 'Belum ada data',
                    ],
                    'year' => $year,
                    'summary' => [
                        'total_locations' => $totalLocations,
                        'locations_in_year' => (int) ($locationStats->locations_in_year ?? 0),
                        'carbon_absorption' => $carbon['total'],
                        'carbon_absorption_in_year' => $carbon['year_total'],
                        'emission_reduction' => $emission['total'],
                        'emission_reduction_in_year' => $emission['year_total'],
                        'categories' => $this->categoriesWithCounts($categoryCounts, $categoryYearCounts),
                    ],
                    'chart' => [
                        'labels' => $districts->pluck('name')->all(),
                        'values' => $districts->pluck('total')->all(),
                    ],
                    'updated_at' => $locationStats->updated_at ?? null,
                ];
            }
        );
    }

    private function activeLocations(int $year): Builder
    {
        return DB::table('data_proklims')
            ->where('status_aktif', '1')
            ->where(function ($query) use ($year) {
                $query->whereNull('tanggal_aktif')
                    ->orWhereDate('tanggal_aktif', '<=', "{$year}-12-31");
            });
    }

    private function environmentalTotals(string $table, int $year, int $regencyId): array
    {
        $totals = DB::table($table)
            ->join('data_proklims', "{$table}.data_proklim_id", '=', 'data_proklims.id')
            ->where('data_proklims.status_aktif', '1')
            ->where('data_proklims.kabupaten_kota_id', $regencyId)
            ->where("{$table}.tahun", '<=', $year)
            ->selectRaw(
                "COALESCE(SUM({$table}.nilai), 0) as total, ".
                "COALESCE(SUM(CASE WHEN {$table}.tahun = ? THEN {$table}.nilai ELSE 0 END), 0) as year_total",
                [$year]
            )
            ->first();

        return [
            'total' => (float) ($totals->total ?? 0),
            'year_total' => (float) ($totals->year_total ?? 0),
        ];
    }

    private function categoriesWithCounts(Collection $counts, ?Collection $yearCounts = null): array
    {
        return MdKategoriProklim::query()
            ->statusAktif()
            ->orderBy('nama')
            ->get(['id', 'nama'])
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->nama,
                'total' => (int) ($counts[$category->id] ?? 0),
                'year_total' => (int) (($yearCounts ?? $counts)[$category->id] ?? 0),
            ])
            ->all();
    }

    private function regionHeaders(int $year): array
    {
        return DB::table('regencies')
            ->leftJoin('data_proklims', function ($join) use ($year) {
                $join->on('data_proklims.kabupaten_kota_id', '=', 'regencies.id')
                    ->where('data_proklims.status_aktif', '=', '1')
                    ->where(function ($query) use ($year) {
                        $query->whereNull('data_proklims.tanggal_aktif')
                            ->orWhereDate('data_proklims.tanggal_aktif', '<=', "{$year}-12-31");
                    });
            })
            ->select('regencies.id', 'regencies.name', DB::raw('COUNT(data_proklims.id) as total_locations'))
            ->groupBy('regencies.id', 'regencies.name')
            ->orderBy('regencies.name')
            ->get()
            ->map(fn ($region) => [
                'id' => $region->id,
                'name' => $region->name,
                'total_locations' => (int) $region->total_locations,
                'status' => (int) $region->total_locations > 0 ? 'Aktif' : 'Belum ada data',
            ])
            ->all();
    }
}
