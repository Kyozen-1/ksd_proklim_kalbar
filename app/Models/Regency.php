<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';
    protected $guarded = 'id';

    public function kegiatan()
    {
        return $this->hasMany('App\Models\Kegiatan', 'kabupaten_kota_id');
    }
}
