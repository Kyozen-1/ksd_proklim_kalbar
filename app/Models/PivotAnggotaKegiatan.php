<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PivotAnggotaKegiatan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kegiatan_id');
    }

    public function anggota_pelaksana()
    {
        return $this->belongsTo('App\Models\AnggotaPelaksana', 'anggota_pelaksana_id');
    }
}
