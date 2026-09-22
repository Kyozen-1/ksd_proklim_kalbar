<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdSektorUtamaEmisi extends Model
{
    public function jenis_emisi()
    {
        return $this->hasMany('App\Models\MdJenisEmisi', 'sektor_utama_emisi_id');
    }

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }
}
