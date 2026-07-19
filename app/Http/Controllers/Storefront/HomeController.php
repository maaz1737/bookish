<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        dd('HomeController reached');
        $heroBanners = Cache::remember('home.hero_banners', now()->addHour(), function () {
            return Banner::where('is_active', true)
                ->orderBy('order')
                ->take(1)
                ->get();
        });
        $schools = School::where('is_active', true)
            ->limit(3)
            ->get();
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->where('show_on_dashboard', true)
            ->withCount('products')
            ->limit(3)
            ->get();
        $bestSellers = Product::active()
            ->where('is_best_seller', true)
            ->with('category', 'subCategory')
            ->latest()
            ->take(3)
            ->get();

        $bundles = Bundle::where('is_active', true)
            ->with(['products', 'schoolClass'])
            ->latest()
            ->take(3)
            ->get();


        return view('storefront.home', compact(
            'heroBanners',
            'schools',
            'categories',
            'bestSellers',
            'bundles'
        ));
    }
}
