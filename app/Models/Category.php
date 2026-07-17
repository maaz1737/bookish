<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'is_active',
        'show_on_dashboard',
        'show_on_menu',
        'order'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'show_on_dashboard' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function childProducts()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function allChildren()
    {
        return $this->children()
            ->with('allChildren');
    }

    public function childrenShowOnDas()
    {
        return $this->children()
            ->where('show_on_menu', true)
            ->with('childrenShowOnDas');
    }

    public function imageUrl()
    {

        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/category.png');

    }

    /**
     * Check if this category or any of its children have products.
     * Checks both category_id (direct) and sub_category_id (sub-category) columns.
     */
    public function hasAnyProducts(): bool
    {
        // Direct products under this category
        if ($this->products()->exists()) {
            return true;
        }

        // Products linked via sub_category_id to any child
        if ($this->children()->exists()) {
            $childIds = $this->children()->pluck('id');
            if (\App\Models\Product::whereIn('sub_category_id', $childIds)->exists()) {
                return true;
            }
            if (\App\Models\Product::whereIn('category_id', $childIds)->exists()) {
                return true;
            }
        }

        return false;
    }
}


