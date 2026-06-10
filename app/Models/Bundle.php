<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = ['school_id', 'class_id', 'total_price', 'discount', 'final_price', 'is_active'];

    protected $casts = [
        'is_active'   => 'boolean',
        'total_price' => 'decimal:2',
        'discount'    => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items')
                    ->withPivot('quantity')->withTimestamps();
    }
}
