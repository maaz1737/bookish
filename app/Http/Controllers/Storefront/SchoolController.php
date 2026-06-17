<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\School;

class SchoolController extends Controller
{
    public function index()
    {
        return view('storefront.schools', [
            'schools' => School::where('is_active', true)->withCount('classes')->get(),
        ]);
    }

    public function show(School $school)
    {
        $school->load([
            'classes' => fn($q) => $q->where('is_active', true),
            'products' => fn($q) => $q->whereNull('class_id'),
        ]);

        $products = Product::with('category')
            ->whereHas('category', function ($q) {
                $q->where('type', 'accessory');
            })
            ->get();

        return view('storefront.school', compact('school', 'products'));
    }
}
