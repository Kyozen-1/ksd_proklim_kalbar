<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReduksiEmisiProklim extends Model
{
    public function data_proklim()
    {
        return $this->belongsTo('App\Models\DataProklim', 'data_proklim_id');
    }
}
