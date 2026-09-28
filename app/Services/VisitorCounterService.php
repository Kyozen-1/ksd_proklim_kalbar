<?php

namespace App\Services;

use App\Models\WebsiteVisitStat;
use Illuminate\Http\Request;
use Throwable;

class VisitorCounterService
{
    private const SESSION_KEY = 'public_website_visit_counted';

    public function record(Request $request): array
    {
        $now = now();
        $visitDate = $now->toDateString();

        try {
            if (! $request->session()->has(self::SESSION_KEY)) {
                WebsiteVisitStat::query()->insertOrIgnore([
                    'visit_date' => $visitDate,
                    'visits' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                WebsiteVisitStat::query()
                    ->where('visit_date', $visitDate)
                    ->increment('visits', 1, ['updated_at' => $now]);

                $request->session()->put(self::SESSION_KEY, true);
            }

            $counts = WebsiteVisitStat::query()
                ->selectRaw('COALESCE(SUM(visits), 0) as total')
                ->selectRaw(
                    'COALESCE(SUM(CASE WHEN visit_date BETWEEN ? AND ? THEN visits ELSE 0 END), 0) as monthly',
                    [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()]
                )
                ->first();

            $total = (int) $counts->total;
            $monthly = (int) $counts->monthly;
        } catch (Throwable $exception) {
            report($exception);
            $total = 0;
            $monthly = 0;
        }

        return [
            'total' => $total,
            'monthly' => $monthly,
            'month_label' => $now->locale('id')->translatedFormat('F Y'),
        ];
    }
}
