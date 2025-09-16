<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Services\CloudinaryService;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'cloudinary_public_id',
        'parent_id',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeRootCategories(Builder $query): Builder
    {
        return $query->whereNull('parent_id')->orderBy('sort_order');
    }

    public function scopeWithChildren(Builder $query): Builder
    {
        return $query->with('children');
    }

    // Helper Methods
    public function getFullNameAttribute()
    {
        $names = collect([$this->name]);
        $parent = $this->parent;

        while ($parent) {
            $names->prepend($parent->name);
            $parent = $parent->parent;
        }

        return $names->implode(' > ');
    }

    public function getAllChildrenIds()
    {
        $ids = collect([$this->id]);

        foreach ($this->children as $child) {
            $ids = $ids->merge($child->getAllChildrenIds());
        }

        return $ids;
    }

    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    public function getDepthLevel()
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    /**
     * Get image URLs from Cloudinary
     */
    public function getImageUrlsAttribute()
    {
        if (!$this->cloudinary_public_id) {
            return null;
        }

        $cloudinaryService = app(CloudinaryService::class);
        return $cloudinaryService->getCategoryImageUrls($this->cloudinary_public_id);
    }

    /**
     * Get the image URL (fallback to regular image if no Cloudinary image)
     */
    public function getImageUrlAttribute()
    {
        if ($this->cloudinary_public_id) {
            $cloudinaryService = app(CloudinaryService::class);
            $urls = $cloudinaryService->getCategoryImageUrls($this->cloudinary_public_id);
            return $urls['medium'];
        }

        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
