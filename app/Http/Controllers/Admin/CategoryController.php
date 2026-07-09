<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->whereNull("parent_id")->get();
        return view("admin.categories.create", compact('categories'));
    }

    public function edit(Category $category)
    {
        $categories = Category::select('id', 'name')
            ->whereNull("parent_id")
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (!empty($data['parent_id'])) {
            $parentCategory = Category::find($data['parent_id']);
            if ($parentCategory && $parentCategory->parent_id != null) {
                return back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'This category is already a child category. You cannot nest it further.']);
            }
        }

        $data['slug'] = Str::slug($data['name']);
        if (Category::where('slug', $data['slug'])->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'A category with this name or slug already exists.']);
        }

        $data['show_on_dashboard'] = $request->has('show_on_dashboard');
        $data['show_on_menu'] = $request->has('show_on_menu');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        Cache::forget('menu.main_categories');
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (!empty($data['parent_id']) && $data['parent_id'] == $category->id) {
            return back()
                ->withInput()
                ->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        if (!empty($data['parent_id'])) {
            $parentCategory = Category::find($data['parent_id']);
            if ($parentCategory && $parentCategory->parent_id != null) {
                return back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'This category is already a child category.']);
            }
        }

        $data['slug'] = Str::slug($data['name']);
        if (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'A category with this name or slug already exists.']);
        }

        $data['show_on_dashboard'] = $request->has('show_on_dashboard');
        $data['show_on_menu'] = $request->has('show_on_menu');

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        Cache::forget('menu.main_categories');
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        Cache::forget('menu.main_categories');
        return back()->with('success', 'Category deleted.');
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
            return back()->with('error', 'Please select at least one category to delete.');
        }

        $categories = Category::whereIn('id', $ids)->get();

        if ($categories->isEmpty()) {
            return back()->with('error', 'No categories were found for deletion.');
        }

        foreach ($categories as $cat) {
            if ($cat->image && Storage::disk('public')->exists($cat->image)) {
                Storage::disk('public')->delete($cat->image);
            }
            $cat->delete();
        }
        Cache::forget('menu.main_categories');
        return back()->with('success', count($categories) . ' category/ies deleted.');
    }

    public function getCategories($id)
    {
        $category = Category::with('children')->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'category' => $category,
        ], 200);
    }
}