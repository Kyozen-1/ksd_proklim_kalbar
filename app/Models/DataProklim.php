<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DataProklim extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\District', 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Models\Village', 'kelurahan_id');
    }

    public function kategori_proklim()
    {
        return $this->belongsTo('App\Models\MdKategoriProklim', 'kategori_proklim_id');
    }

    public function serapan_karbon_proklim()
    {
        return $this->hasMany('App\Models\SerapanKarbonProklim', 'data_proklim_id');
    }

    public function reduksi_emisi_proklim()
    {
        return $this->hasMany('App\Models\ReduksiEmisiProklim', 'data_proklim_id');
    }
}
