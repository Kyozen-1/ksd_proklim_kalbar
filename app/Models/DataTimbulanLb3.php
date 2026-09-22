<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTimbulanLb3 extends Model
{
    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }

    public function sektor_lb3()
    {
        return $this->belongsTo('App\Models\MdSektorLb3', 'sektor_lb3_id');
    }
}
