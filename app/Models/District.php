<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $guarded = 'id';

    public function data_proklim()
    {
        return $this->hasMany('App\Models\DataProklim', 'kecamatan_id');
    }

    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'regency_id');
    }

    public function kelurahan()
    {
        return $this->hasMany('App\Models\Village', 'district_id');
    }
}
