<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MasterJabatan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function anggota_pelaksana()
    {
        return $this->hasMany('App\Models\AnggotaPelaksana', 'jabatan_id');
    }
}
