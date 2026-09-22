<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdKategoriSampah extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function data_sampah()
    {
        return $this->hasMany('App\Models\DataSampah', 'kategori_sampah_id');
    }
}
