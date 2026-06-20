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
        return view('storefront.home', [
            'heroBanners'       => Banner::where('is_active', true)->orderBy('order', 'asc')->get(),
            'schools'           => School::where('is_active', true)->get(),
            'categories'        => Category::where('is_active', true)->where('show_on_dashboard', true)->get(),
            // Featured / New arrivals
            'featuredProducts'  => Product::active()->latest()->take(8)->get(),
            // Best sellers (low stock = sold more)
            'bestSellers'       => Product::active()->orderBy('stock', 'asc')->take(8)->get(),
            // Discounted products
            'onSaleProducts'    => Product::active()
                                    ->whereNotNull('discount_price')
                                    ->whereColumn('discount_price', '<', 'price')
                                    ->latest()
                                    ->take(8)
                                    ->get(),
        ]);
    }
}
