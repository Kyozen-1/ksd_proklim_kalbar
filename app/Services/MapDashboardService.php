<?php

namespace App\Services;

use App\Models\MapLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MapDashboardService
{
    public const FEATURES = [
        'proklim' => ['label' => 'Proklim', 'color' => '#d97706', 'icon' => 'fa-solid fa-leaf'],
        'igrk' => ['label' => 'IGRK', 'color' => '#059669', 'icon' => 'fa-solid fa-wind'],
        'sampah' => ['label' => 'Sampah', 'color' => '#b91c1c', 'icon' => 'fa-solid fa-trash-can'],
        'kualitas-lingkungan' => ['label' => 'Kualitas Lingkungan', 'color' => '#0369a1', 'icon' => 'fa-solid fa-water'],
        'lb3' => ['label' => 'LB3', 'color' => '#a21caf', 'icon' => 'fa-solid fa-flask'],
    ];

    public function pageConfig(): array
    {
        return [
            'features' => collect(self::FEATURES)
                ->map(fn (array $config, string $key) => ['key' => $key, ...$config])
                ->values()
                ->all(),
            'regions' => Cache::remember('public:map:regions', 3600, fn () => DB::table('regencies')
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn ($region) => ['id' => $region->id, 'name' => $region->name])
                ->all()),
        ];
    }

    public function markers(array $filters): array
    {
        $limit = min((int) ($filters['limit'] ?? 500), 500);
        $query = MapLocation::query()
            ->where('status_aktif', true)
            ->with('regency:id,name')
            ->select(['id', 'regency_id', 'feature', 'title', 'category', 'latitude', 'longitude']);

        $features = array_values(array_intersect(
            $filters['features'] ?? array_keys(self::FEATURES),
            array_keys(self::FEATURES)
        ));
        $query->whereIn('feature', $features);

        if (!empty($filters['regency'])) {
            $query->where('regency_id', $filters['regency']);
        }

        if (!empty($filters['search'])) {
            $search = '%'.mb_strtolower($filters['search']).'%';
            $query->where(function (Builder $query) use ($search) {
                $query->whereRaw('LOWER(title) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(category) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(address) LIKE ?', [$search]);
            });
        }

        if (!empty($filters['bounds'])) {
            [$west, $south, $east, $north] = $filters['bounds'];
            $query->whereBetween('latitude', [$south, $north])
                ->whereBetween('longitude', [$west, $east]);
        }

        $locations = $query->orderBy('id')->limit($limit + 1)->get();
        $truncated = $locations->count() > $limit;

        return [
            'markers' => $locations->take($limit)->map(fn (MapLocation $location) => [
                'id' => $location->id,
                'feature' => $location->feature,
                'title' => $location->title,
                'category' => $location->category,
                'region' => $location->regency?->name,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ])->values()->all(),
            'count' => min($locations->count(), $limit),
            'truncated' => $truncated,
            'limit' => $limit,
        ];
    }

    public function detail(MapLocation $location): array
    {
        abort_unless($location->status_aktif, 404);
        $location->loadMissing('regency:id,name');

        return [
            'id' => $location->id,
            'feature' => $location->feature,
            'feature_label' => self::FEATURES[$location->feature]['label'] ?? $location->feature,
            'title' => $location->title,
            'category' => $location->category,
            'region' => $location->regency?->name,
            'address' => $location->address,
            'description' => $location->description,
            'metric' => $location->metric_label ? [
                'label' => $location->metric_label,
                'value' => $location->metric_value,
                'unit' => $location->metric_unit,
            ] : null,
            'additional_info' => $location->additional_info,
            'source_url' => $location->source_url,
            'image_url' => $location->image_url
                ? (str_starts_with($location->image_url, 'http') ? $location->image_url : asset(ltrim($location->image_url, '/')))
                : null,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ];
    }
}
