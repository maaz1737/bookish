<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('schools', 'public');
        }
        
        School::create($data);
        return back()->with('success', 'School created.');
    }
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('schools', 'name')->ignore($school->id),
            ],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);
        
        if ($request->hasFile('logo')) {
            if ($school->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($school->logo);
            }
            $data['logo'] = $request->file('logo')->store('schools', 'public');
        }

        $school->update($data);

        return redirect()->route('admin.schools.index')->with('success', 'School updated.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return back()->with('success', 'School deleted.');
    }
}
