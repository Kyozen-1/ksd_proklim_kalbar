<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kegiatan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }

    public function pivot_gambar_kegiatan()
    {
        return $this->hasMany('App\Models\PivotGambarKegiatan', 'kegiatan_id');
    }

    public function pivot_anggota_kegiatan()
    {
        return $this->hasMany('App\Models\PivotAnggotaKegiatan', 'kegiatan_id');
    }
}
