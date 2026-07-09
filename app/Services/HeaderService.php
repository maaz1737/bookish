<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\School;
use Illuminate\Support\Facades\Cache;


class HeaderService
{
    public function data()
    {
        return [
            'mainSchools' => School::where('is_active', true)
                ->select('slug', 'name', 'logo')
                ->orderBy('name')
                ->take(5)
                ->get(),
            'mainCategories' => Cache::remember(
                'menu.main_categories',
                now()->addDay(),
                function () {
                    return Category::whereNull('parent_id')
                        ->where('show_on_menu', true)
                        ->with('children')
                        ->get();
                }
            )
        ];
    }
}