<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->paginate(10);

        return view('admin.categories', compact('categories'));
    }
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view("admin.categories.create", compact('categories'));
    }
    public function edit(Category $category)
    {
        $categories = Category::select('id', 'name')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', 'different:id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);


        $data['slug'] = Str::slug($data['name']);
        $data['show_on_dashboard'] = $request->has('show_on_dashboard');
        $data['show_on_menu'] = $request->has('show_on_menu');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        Category::create($data);
        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', 'different:id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $data['show_on_dashboard'] = $request->has('show_on_dashboard');
        $data['show_on_menu'] = $request->has('show_on_menu');

        if ($request->hasFile('image')) {

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function getCategories($id)
    {

        $category = Category::with('allChildren')->find($id);

        return response()->json([
            'category' => $category,
        ], 200);

    }

}
