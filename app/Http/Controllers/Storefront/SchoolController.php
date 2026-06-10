<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
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
        $school->load(['classes' => fn ($q) => $q->where('is_active', true)]);

        return view('storefront.school', compact('school'));
    }
}
