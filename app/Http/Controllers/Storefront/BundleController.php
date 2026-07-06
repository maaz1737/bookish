<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = \App\Models\Bundle::where('is_active', true)
            ->with(['products', 'schoolClass'])
            ->latest()
            ->paginate(12);

        return view('storefront.bundles', compact('bundles'));
    }

    // SEO route: /school/{school}/{class}/bundle
    public function show(School $school, string $classSlug)
    {
        $class = SchoolClass::where('school_id', $school->id)
            ->where('slug', $classSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $bundle = $class->bundle()->with('items.product.category')->first();


        // Publisher is hidden automatically by the Product model's $hidden.
        return view('storefront.bundle', [
            'school' => $school,
            'class'  => $class,
            'bundle' => $bundle,
            'seo'    => [
                'title'       => "{$class->name} books Pakistan | {$school->name} book bundle",
                'description' => "Buy school books online in Pakistan — {$school->name} {$class->name} complete bundle at a discounted price.",
                'keywords'    => "{$class->name} books Pakistan, {$school->name} book bundle, buy school books online in Pakistan",
            ],
        ]);
    }
}
