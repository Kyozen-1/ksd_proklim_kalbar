<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AnggotaPelaksana extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Models\MasterJabatan', 'jabatan_id');
    }

    public function pivot_anggota_kegiatan()
    {
        return $this->hasMany('App\Models\PivotAnggotaKegiatan', 'anggota_kegiatan_id');
    }

    public function getFotoPathAttribute()
    {
        return Storage::disk('minio')->temporaryUrl($this->foto,
            now()->addMinutes(30));
    }
}
