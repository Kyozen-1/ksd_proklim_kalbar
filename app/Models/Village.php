<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'villages';
    protected $guarded = 'id';

    public function data_proklim()
    {
        return $this->hasMany('App\Models\DataProklim', 'kelurahan_id');
    }
}
