<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'school_id' => ['required', 'exists:schools,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('school_classes', 'name'),
            ],
            'sort_order' => ['required', 'integer'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        SchoolClass::create($data);

        return back()->with('success', 'Class created.');
    }

    public function edit(SchoolClass $class)
    {
        $class->load('school');
        $schools = School::select('id', 'name')->get();
        return view('admin.classes.edit', compact('class', 'schools'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('school_classes', 'name')->ignore($class->id),
            ],
            'sort_order' => ['required', 'integer'],
        ]);

        $data['slug'] = Str::slug($data['name']);


        $class->update($data);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return back()->with('success', 'Class deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = collect($request->input('selected', []))
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        if (empty($ids)) {
            return back()->with('error', 'Please select at least one class to delete.');
        }

        $classes = SchoolClass::whereIn('id', $ids)->get();

        if ($classes->isEmpty()) {
            return back()->with('error', 'No classes were found for deletion.');
        }

        $classes->each->delete();

        return back()->with('success', count($classes) . ' class(es) deleted.');
    }
}
