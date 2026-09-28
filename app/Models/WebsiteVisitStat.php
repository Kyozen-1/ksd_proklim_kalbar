<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVisitStat extends Model
{
    protected $fillable = [
        'visit_date',
        'visits',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visits' => 'integer',
    ];
}
