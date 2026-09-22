<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdSektorLb3 extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function data_timbulan_lb3()
    {
        return $this->hasMany('App\Models\DataTimbulanLb3', 'sektor_lb3_id');
    }
}
