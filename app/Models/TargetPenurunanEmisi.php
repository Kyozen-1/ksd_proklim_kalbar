<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetPenurunanEmisi extends Model
{
    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }
}
