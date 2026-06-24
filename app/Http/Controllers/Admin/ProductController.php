<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Admins CAN see publisher -> makeVisible
        $products = Product::with('category', 'school')->latest()->paginate(20)
            ->through(fn($p) => $p->makeVisible('publisher'));

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', $this->formData());
    }

    // public function store(StoreProductRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
    //     $data['images'] = $this->storeImages($request);

    //     $product = Product::create($data);



    //     return redirect()->route('admin.products.index')->with('success', 'Product created.');
    // }

    public function store(StoreProductRequest $request)
    {
        try {

            DB::beginTransaction();

            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
            $data['images'] = $this->storeImages($request);

            $product = Product::create($data);

            $this->syncProductBundle($product);

            DB::commit();

            if ($request->input('has_variant')) {

                return redirect()
                    ->route('admin.products.attribute.select', ['product' => $product->slug])
                    ->with('success', 'Product created.');
            } else {
                return redirect()->route('admin.products.index')->with('success', 'Product created.');
            }



        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }



    public function edit(Product $product)
    {
        $product->makeVisible('publisher');
        return view('admin.products.edit', array_merge($this->formData(), compact('product')));
    }
    private function syncProductBundle(Product $product)
    {
        BundleItem::where('product_id', $product->id)->delete();

        if (!$product->school_id || !$product->class_id) {
            return;
        }

        $bundle = Bundle::firstOrCreate(
            [
                'school_id' => $product->school_id,
                'class_id' => $product->class_id,
            ],
            [
                'total_price' => 0,
                'discount' => 0,
                'final_price' => 0,
                'is_active' => true,
            ]
        );

        // Prevent duplicate bundle item
        $bundle->items()->firstOrCreate([
            'product_id' => $product->id,
        ], [
            'quantity' => 1,
        ]);

        $items = $bundle->items()->with('product')->get();

        $totalPrice = 0;
        $totalDiscountPrice = 0;

        foreach ($items as $item) {

            $price = $item->product->price * $item->quantity;

            $discountPrice = ($item->product->discount_price ?? $item->product->price)
                * $item->quantity;

            $totalPrice += $price;
            $totalDiscountPrice += $discountPrice;
        }
        $bundle->update([
            'total_price' => $totalPrice,
            'discount' => $totalDiscountPrice,
            'final_price' => $totalDiscountPrice,
        ]);
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

        $this->syncProductBundle($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated.');
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
            'schools' => School::where('is_active', true)->get(),
            'classes' => collect(),
        ];
    }

    private function storeImages(Request $request): array
    {
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        $paths = [];

        foreach ((array) $request->file('images', []) as $file) {
            $paths[] = $file->store('products', 'public');
        }

        return $paths;
    }
}
