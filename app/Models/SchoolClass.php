<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'school_classes';

    protected $fillable = ['school_id', 'name', 'slug', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function bundle()
    {
        return $this->hasOne(Bundle::class, 'class_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'class_id');
    }
}
