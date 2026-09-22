<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahPenduduk extends Model
{
    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }
}
