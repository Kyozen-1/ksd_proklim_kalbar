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
}
