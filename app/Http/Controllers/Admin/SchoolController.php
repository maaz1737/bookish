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
            'name' => ['required', 'string', 'max:255', 'unique:schools,name'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        School::create($data);
        return back()->with('success', 'School created.');
    }
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $school->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]));
        return redirect()->route('admin.schools.index')->with('success', 'School updated.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return back()->with('success', 'School deleted.');
    }
}
