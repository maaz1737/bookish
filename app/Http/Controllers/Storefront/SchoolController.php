<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
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
            'classes' => fn($q) => $q->where('is_active', true)->withCount('products'),
            'classes.products',
        ]);

        $bundles = Bundle::where('school_id', $school->id)
            ->where('is_active', true)
            ->with(['schoolClass', 'products'])
            ->get();

        return view('storefront.school', compact('school', 'bundles'));
    }
}
