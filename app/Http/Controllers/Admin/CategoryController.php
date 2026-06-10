<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', ['categories' => Category::withCount('products')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:book,uniform,accessory'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'type'      => ['required', 'in:book,uniform,accessory'],
            'is_active' => ['boolean'],
        ]));
        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
