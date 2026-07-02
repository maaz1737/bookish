<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = ['name', 'status'];

    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }

}
