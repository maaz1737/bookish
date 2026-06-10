<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // Admins CAN see publisher -> makeVisible
        $products = Product::with('category', 'school')->latest()->paginate(20)
            ->through(fn ($p) => $p->makeVisible('publisher'));

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', $this->formData());
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(5);
        $data['images'] = $this->storeImages($request);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $product->makeVisible('publisher');
        return view('admin.products.edit', array_merge($this->formData(), compact('product')));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('images')) {
            $data['images'] = $this->storeImages($request);
        } else {
            unset($data['images']);
        }
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    private function formData(): array
    {
        return [
            'categories' => Category::where('is_active', true)->get(),
            'schools'    => School::where('is_active', true)->get(),
            'classes'    => SchoolClass::where('is_active', true)->get(),
        ];
    }

    private function storeImages(Request $request): array
    {
        $paths = [];
        foreach ((array) $request->file('images', []) as $file) {
            $paths[] = $file->store('products', 'public');
        }
        return $paths;
    }
}
