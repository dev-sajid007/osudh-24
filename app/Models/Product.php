<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\CloudinaryService;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'generic_name',
        'sku',
        'barcode',
        'dosage',
        'form',
        'strength',
        'package_size',
        'prescription_required',
        'category_id',
        'generic_id',
        'sub_category',
        'description',
        'images',
        'unit_price',
        'mrp',
        'discount',
        'tax_rate',
        'supplier_id',
        'stock_quantity',
        'expiry_date',
        'storage_instructions',
        'slug',
        'status',
        'minimum_stock',
        'maximum_stock',
        'side_effects',
        'usage_instructions',
        'tags',
        'cloudinary_public_ids',
        'is_active' // ✅ IMPORTANT (added for safety)
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'cloudinary_public_ids' => 'array',
        'prescription_required' => 'boolean',
        'unit_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }

            if (!isset($product->is_active)) {
                $product->is_active = 1;
            }
        });
    }

    // ========================
    // RELATIONS
    // ========================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function generic(): BelongsTo
    {
        return $this->belongsTo(Generic::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // ========================
    // ACCESSORS
    // ========================

    public function getFinalPriceAttribute()
    {
        return $this->unit_price - ($this->unit_price * $this->discount / 100);
    }

    public function getIsLowStockAttribute()
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date < now()->toDateString();
    }

    public function getIsExpiringSoonAttribute()
    {
        return $this->expiry_date && $this->expiry_date <= now()->addDays(30)->toDateString();
    }

    public function getAvailabilityStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->is_low_stock) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    // ========================
    // SCOPES (FIXED SECTION)
    // ========================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopePrescriptionRequired(Builder $query): Builder
    {
        return $query->where('prescription_required', true);
    }

    public function scopeOtc(Builder $query): Builder
    {
        return $query->where('prescription_required', false);
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereRaw('stock_quantity <= minimum_stock');
    }

    public function scopeExpiringSoon(Builder $query, int $days = 30): Builder
    {
        return $query->where('expiry_date', '<=', now()->addDays($days))
            ->where('expiry_date', '>', now());
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expiry_date', '<', now());
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('generic_name', 'like', "%{$term}%")
              ->orWhere('brand', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('barcode', 'like', "%{$term}%");
        });
    }

    public function scopeByCategory(Builder $query, $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByGeneric(Builder $query, $genericId): Builder
    {
        return $query->where('generic_id', $genericId);
    }

    public function scopePriceRange(Builder $query, $min = null, $max = null): Builder
    {
        if ($min !== null) {
            $query->where('unit_price', '>=', $min);
        }

        if ($max !== null) {
            $query->where('unit_price', '<=', $max);
        }

        return $query;
    }

    // ========================
    // IMAGE HANDLING
    // ========================

    public function getImageUrlsAttribute()
    {
        $imageUrls = [];

        if ($this->cloudinary_public_ids && is_array($this->cloudinary_public_ids)) {
            $cloudinaryService = app(CloudinaryService::class);

            foreach ($this->cloudinary_public_ids as $publicId) {
                $imageUrls[] = $cloudinaryService->getProductImageUrls($publicId);
            }
        } elseif ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                $imageUrls[] = [
                    'original' => asset('storage/' . $image),
                    'thumbnail' => asset('storage/' . $image),
                    'medium' => asset('storage/' . $image),
                    'large' => asset('storage/' . $image),
                ];
            }
        }

        return $imageUrls;
    }

    public function getPrimaryImageUrlAttribute()
    {
        return $this->image_urls[0]['medium'] ?? null;
    }

    public function getThumbnailImageUrlAttribute()
    {
        return $this->image_urls[0]['thumbnail'] ?? null;
    }
}