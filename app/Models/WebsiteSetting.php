<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    protected $table = 'website_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public static function getAllSettings(): array
    {
        return Cache::remember('website_settings_all', 3600, function () {
            return static::active()->pluck('value', 'key')->toArray();
        });
    }
}