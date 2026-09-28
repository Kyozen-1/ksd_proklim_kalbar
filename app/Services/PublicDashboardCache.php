<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class PublicDashboardCache
{
    private const KEY_REVISION = 'r2';

    private const VERSION_PREFIX = 'public-dashboard-version:';

    public static function key(string $feature, string $suffix): string
    {
        $version = (int) Cache::get(self::VERSION_PREFIX.$feature, 1);

        return 'public:'.$feature.':'.self::KEY_REVISION.":v{$version}:{$suffix}";
    }

    public static function invalidate(string $feature): void
    {
        $versionKey = self::VERSION_PREFIX.$feature;
        $nextVersion = (int) Cache::get($versionKey, 1) + 1;

        Cache::forever($versionKey, $nextVersion);
    }
}
