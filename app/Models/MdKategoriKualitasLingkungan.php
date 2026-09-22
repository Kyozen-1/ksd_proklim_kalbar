<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdKategoriKualitasLingkungan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function data_kualitas_lingkungan()
    {
        return $this->hasMany('App\Models\DataKualitasLingkungan', 'kategori_kualitas_lingkungan_id');
    }
}
