<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
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

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('label');
    }

    // Static methods for easy access
    public static function get(string $key, $default = null)
    {
        return Cache::remember("website_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->where('is_active', true)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): bool
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("website_setting_{$key}");
        return (bool) $setting;
    }

    public static function getGroup(string $group): array
    {
        return Cache::remember("website_settings_{$group}", 3600, function () use ($group) {
            return static::active()
                ->byGroup($group)
                ->ordered()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function getAllSettings(): array
    {
        return Cache::remember('website_settings_all', 3600, function () {
            return static::active()->pluck('value', 'key')->toArray();
        });
    }

    // Clear cache when model is updated
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget("website_setting_{$setting->key}");
            Cache::forget("website_settings_{$setting->group}");
            Cache::forget('website_settings_all');
        });

        static::deleted(function ($setting) {
            Cache::forget("website_setting_{$setting->key}");
            Cache::forget("website_settings_{$setting->group}");
            Cache::forget('website_settings_all');
        });
    }
}
