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
}


