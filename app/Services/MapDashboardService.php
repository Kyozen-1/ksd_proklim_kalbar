<?php

namespace App\Services;

use App\Models\DataProklim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MapDashboardService
{
    public const FEATURES = [
        'proklim' => ['label' => 'Proklim', 'color' => '#d97706', 'icon' => 'fa-solid fa-leaf'],
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
        $features = array_values(array_intersect(
            $filters['features'] ?? array_keys(self::FEATURES),
            array_keys(self::FEATURES)
        ));

        $markers = in_array('proklim', $features, true)
            ? $this->proklimMarkers($filters, $limit + 1)
            : collect();

        return [
            'markers' => $markers->take($limit)->all(),
            'count' => min($markers->count(), $limit),
            'truncated' => $markers->count() > $limit,
            'limit' => $limit,
        ];
    }

    public function detail(string $markerKey): array
    {
        if (preg_match('/^proklim-(\d+)$/', $markerKey, $matches) === 1) {
            return $this->proklimDetail((int) $matches[1]);
        }

        abort(404);
    }

    private function proklimMarkers(array $filters, int $limit): Collection
    {
        $query = DB::table('data_proklims as proklim')
            ->leftJoin('regencies as regency', 'regency.id', '=', 'proklim.kabupaten_kota_id')
            ->leftJoin('md_kategori_proklims as category', 'category.id', '=', 'proklim.kategori_proklim_id')
            ->whereNotNull('proklim.lat')
            ->whereNotNull('proklim.lng')
            ->where('proklim.lat', '!=', '')
            ->where('proklim.lng', '!=', '');

        if (! empty($filters['regency'])) {
            $query->where('proklim.kabupaten_kota_id', $filters['regency']);
        }

        if (! empty($filters['search'])) {
            $search = '%'.mb_strtolower($filters['search']).'%';
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(proklim.nama) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(proklim.alamat) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(proklim.deskripsi) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(category.nama) LIKE ?', [$search]);
            });
        }

        if (! empty($filters['bounds'])) {
            [$west, $south, $east, $north] = $filters['bounds'];
            $coordinateType = DB::connection()->getDriverName() === 'sqlite' ? 'REAL' : 'DECIMAL(20, 10)';
            $query->whereRaw("CAST(proklim.lat AS {$coordinateType}) BETWEEN ? AND ?", [$south, $north])
                ->whereRaw("CAST(proklim.lng AS {$coordinateType}) BETWEEN ? AND ?", [$west, $east]);
        }

        return $query
            ->orderBy('proklim.id')
            ->limit($limit)
            ->get([
                'proklim.id',
                'proklim.nama',
                'proklim.lat',
                'proklim.lng',
                'category.nama as category_name',
                'regency.name as region_name',
            ])
            ->filter(fn ($location) => is_numeric($location->lat) && is_numeric($location->lng))
            ->map(fn ($location) => [
                'id' => 'proklim-'.$location->id,
                'feature' => 'proklim',
                'title' => $location->nama ?: 'Lokasi PROKLIM',
                'category' => $location->category_name,
                'region' => $location->region_name,
                'latitude' => (float) $location->lat,
                'longitude' => (float) $location->lng,
            ])
            ->values();
    }

    private function proklimDetail(int $id): array
    {
        $proklim = DataProklim::with([
            'kabupaten_kota:id,name',
            'kecamatan:id,name',
            'kelurahan:id,name',
            'kategori_proklim:id,nama',
        ])->findOrFail($id);

        abort_unless(is_numeric($proklim->lat) && is_numeric($proklim->lng), 404);

        $administrativeArea = collect([
            $proklim->kelurahan?->name,
            $proklim->kecamatan?->name,
        ])->filter()->implode(', ');

        return [
            'id' => 'proklim-'.$proklim->id,
            'feature' => 'proklim',
            'feature_label' => self::FEATURES['proklim']['label'],
            'title' => $proklim->nama ?: 'Lokasi PROKLIM',
            'category' => $proklim->kategori_proklim?->nama,
            'region' => $proklim->kabupaten_kota?->name,
            'address' => $proklim->alamat,
            'description' => $proklim->deskripsi,
            'metric' => null,
            'additional_info' => $administrativeArea ?: null,
            'source_url' => null,
            'image_url' => null,
            'latitude' => (float) $proklim->lat,
            'longitude' => (float) $proklim->lng,
        ];
    }
}
