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
            'heroBanners' => \App\Models\Banner::where('is_active', true)->orderBy('order', 'asc')->get(),
            'schools' => School::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->where('parent_id', null)->where('show_on_dashboard', true)->withCount('products')->get(),
            'featured' => Product::active()->latest()->take(8)->get(),
        ]);
    }
}
