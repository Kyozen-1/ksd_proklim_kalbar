<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapLocation extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'metric_value' => 'float',
            'status_aktif' => 'boolean',
        ];
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}
