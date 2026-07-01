<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = Banner::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        $schools = School::where('is_active', true)
            ->limit(3)
            ->get();
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->where('show_on_dashboard', true)
            ->withCount('products')
            ->limit(4)
            ->get();
        $bestSellers = Product::active()
            ->where('is_best_seller', true)
            ->latest()
            ->take(3)
            ->get();

        $bundles = \App\Models\Bundle::where('is_active', true)
            ->with(['products', 'schoolClass'])
            ->latest()
            ->take(3)
            ->get();

        return view('storefront.home', compact(
            'heroBanners',
            'schools',
            'categories',
            'bestSellers'
        ));
    }
}
