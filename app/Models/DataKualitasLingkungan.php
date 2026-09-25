<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKualitasLingkungan extends Model
{
    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }

    public function kategori_kualitas_lingkungan()
    {
        return $this->belongsTo('App\Models\MdKategoriKualitasLingkungan', 'kategori_kualitas_lingkungan_id');
    }

}
