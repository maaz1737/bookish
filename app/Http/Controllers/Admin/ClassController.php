<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index()
    {
        return view('admin.classes', [
            'classes' => SchoolClass::with('school')->orderBy('school_id')->orderBy('sort_order')->get(),
            'schools' => School::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id'  => ['required', 'exists:schools,id'],
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        SchoolClass::create($data);
        return back()->with('success', 'Class created.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return back()->with('success', 'Class deleted.');
    }
}
