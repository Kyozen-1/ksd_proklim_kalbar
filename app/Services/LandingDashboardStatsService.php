<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LandingDashboardStatsService
{
    public function summary(int $year): array
    {
        $yearStart = "{$year}-01-01";
        $yearEnd = "{$year}-12-31";

        $proklim = DB::table('data_proklims')
            ->where('status_aktif', '1')
            ->where(function ($query) use ($yearEnd) {
                $query->whereNull('tanggal_aktif')
                    ->orWhereDate('tanggal_aktif', '<=', $yearEnd);
            })
            ->selectRaw(
                'COUNT(*) as total, '.
                'COALESCE(SUM(CASE WHEN tanggal_aktif >= ? AND tanggal_aktif <= ? THEN 1 ELSE 0 END), 0) as year_total',
                [$yearStart, $yearEnd]
            )
            ->first();

        $reduction = DB::table('reduksi_emisi_proklims as reductions')
            ->join('data_proklims as proklim', 'reductions.data_proklim_id', '=', 'proklim.id')
            ->where('proklim.status_aktif', '1')
            ->where('reductions.tahun', '<=', $year)
            ->selectRaw(
                'COALESCE(SUM(reductions.nilai), 0) as total, '.
                'COALESCE(SUM(CASE WHEN reductions.tahun = ? THEN reductions.nilai ELSE 0 END), 0) as year_total',
                [$year]
            )
            ->first();

        $emission = DB::table('data_emisis')
            ->where('tahun', '<=', $year)
            ->selectRaw(
                'COALESCE(SUM(nilai), 0) as total, '.
                'COALESCE(SUM(CASE WHEN tahun = ? THEN nilai ELSE 0 END), 0) as year_total',
                [$year]
            )
            ->first();

        return [
            'year' => $year,
            'proklim' => [
                'total' => (int) ($proklim->total ?? 0),
                'year_total' => (int) ($proklim->year_total ?? 0),
            ],
            'emission_reduction' => [
                'total' => (float) ($reduction->total ?? 0),
                'year_total' => (float) ($reduction->year_total ?? 0),
            ],
            'emission' => [
                'total' => (float) ($emission->total ?? 0),
                'year_total' => (float) ($emission->year_total ?? 0),
            ],
        ];
    }
}
