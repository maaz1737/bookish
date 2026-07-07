<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\School;


class HeaderService
{
    public function data()
    {
        return [
            'mainSchools' => School::all(),
            'mainCategories' => Category::whereNull('parent_id')
                ->where('show_on_menu', true)
                ->with([
                    'children' => function ($query) {
                        $query->where('show_on_menu', true);
                    }
                ])
                ->get(),
            'mainProducts' => Product::whereHas('category', function ($q) {
                $q->where('name', 'like', '%gift%')
                    ->orWhere('name', 'like', '%fragrance%');
            })->get(),
        ];
    }
}