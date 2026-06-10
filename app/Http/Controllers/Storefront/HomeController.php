<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;

class HomeController extends Controller
{
    public function index()
    {
        return view('storefront.home', [
            'schools'    => School::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
            'featured'   => Product::active()->latest()->take(8)->get(),
        ]);
    }
}
