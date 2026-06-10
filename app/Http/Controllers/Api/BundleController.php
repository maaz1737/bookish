<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;

class BundleController extends Controller
{
    // GET /api/bundles — dynamic class bundles for the storefront
    public function index()
    {
        $bundles = Bundle::where('is_active', true)
            ->with(['school:id,name,slug', 'schoolClass:id,name,slug', 'items.product:id,name,slug,price,discount_price'])
            ->get();

        return response()->json($bundles);
    }
}
