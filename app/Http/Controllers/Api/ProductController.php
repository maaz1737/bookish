<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products — consumer-facing catalog (publisher never exposed)
    public function index(Request $request)
    {
        $products = Product::active()
            ->when($request->filled('category'), fn ($q) =>
                $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
            ->when($request->filled('school'), fn ($q) =>
                $q->whereHas('school', fn ($s) => $s->where('slug', $request->school)))
            ->select(['id', 'name', 'slug', 'category_id', 'school_id', 'class_id',
                      'price', 'discount_price', 'stock', 'images'])
            ->paginate(24);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        // publisher stays hidden via the model's $hidden array
        return response()->json($product->load('category', 'school'));
    }
}
