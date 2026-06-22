<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SchoolClass;

class ProductController extends Controller
{
    // SEO route: /category/{type}
    public function category(string $slug)
    {

        $category = Category::with('allChildren')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        $products = Product::where('category_id', $category->id)->paginate(24);
        return view('user.categories.categories', compact('category', 'products'));
    }

    // SEO route: /product/{product}
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category', 'school');

        return view('storefront.product', [
            'product' => $product,
            // JSON-LD product schema (Section 14) — note: no publisher exposed.
            'jsonLd'  => [
                '@context'   => 'https://schema.org',
                '@type'      => 'Product',
                'name'       => $product->name,
                'description' => $product->description,
                'offers'     => [
                    '@type'         => 'Offer',
                    'priceCurrency' => 'PKR',
                    'price'         => $product->effectivePrice(),
                    'availability'  => $product->stock > 0
                        ? 'https://schema.org/InStock'
                        : 'https://schema.org/OutOfStock',
                ],
            ],
        ]);
    }
    public function getClasses($schoolId)
    {
        return SchoolClass::where('school_id', $schoolId)->get();
    }
}
