<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'image',
        'is_active',
        'show_on_dashboard'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'show_on_dashboard' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
