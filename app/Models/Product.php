<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'school_id',
        'class_id',
        'price',
        'discount_price',
        'stock',
        'low_stock_threshold',
        'publisher',
        'size',
        'gender',
        'description',
        'images',
        'is_active',
        'is_best_seller',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'is_best_seller' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // Central Rule (Section 10): publisher must NEVER reach customer views.
    // We hide it by default; admin controllers explicitly makeVisible() it.
    protected $hidden = ['publisher'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Effective price honouring an active promotional discount.
    public function effectivePrice(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_threshold;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'product_attributes',
            'product_id',
            'attribute_id'
        );
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function hasVariants(): bool
    {
        return $this->variants()->exists();
    }

}
