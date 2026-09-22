<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdJenisEmisi extends Model
{
    public function sektor_utama_emisi()
    {
        return $this->belongsTo('App\Models\MdSektorUtamaEmisi', 'sektor_utama_emisi_id');
    }

    public function data_emisi()
    {
        return $this->hasMany('App\Models\DataEmisi', 'jenis_emisi_id');
    }

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }
}
