<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApiClient extends Model
{
    protected $table = 'api_clients';

    protected $fillable = [
        'name',
        'client_id',
        'client_secret_hash',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'client_secret_hash',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (
            $this->expires_at !== null &&
            $this->expires_at->isPast()
        ) {
            return false;
        }

        return true;
    }

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('is_active', 1);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            ApiPermission::class,
            'api_client_permissions'
        )->withTimestamps();
    }
}
