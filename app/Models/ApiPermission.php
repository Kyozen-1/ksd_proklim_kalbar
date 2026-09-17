<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApiPermission extends Model
{
    protected $table = 'api_permissions';

    protected $fillable = [
        'name',
        'slug',
        'route_name',
        'method',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(
            ApiClient::class,
            'api_client_permissions'
        )->withTimestamps();
    }
}
