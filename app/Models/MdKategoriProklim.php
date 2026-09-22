<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdKategoriProklim extends Model
{
    public function data_proklim()
    {
        return $this->hasMany('App\Models\DataProklim', 'kategori_proklim_id');
    }

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }
}
