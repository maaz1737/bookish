<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'logo', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
