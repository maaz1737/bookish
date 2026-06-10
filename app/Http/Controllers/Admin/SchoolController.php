<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index()
    {
        return view('admin.schools', ['schools' => School::withCount('classes')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        School::create($data);
        return back()->with('success', 'School created.');
    }

    public function update(Request $request, School $school)
    {
        $school->update($request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
        ]));
        return back()->with('success', 'School updated.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return back()->with('success', 'School deleted.');
    }
}
