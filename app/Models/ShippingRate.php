<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['shipping_zone_id', 'name', 'price', 'min_order_amount', 'estimated_days', 'free_shipping', 'status'];
}
