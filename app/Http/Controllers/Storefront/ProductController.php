<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SchoolClass;

class ProductController extends Controller
{
    public function index()
    {
        $sort  = request('sort', 'latest');
        $query = Product::active()->with('variants');

        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(24);
        return view('storefront.products', compact('products'));
    }


    // SEO route: /category/{type}
    public function category(string $slug)
    {
        $category = Category::whereNull('parent_id')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'products' => function ($q) {
                    $q->where('is_active', true)
                        ->whereNull('sub_category_id')
                        ->latest();
                },
                'children' => function ($q) {
                    $q->where('is_active', true)
                        ->with([
                            'childProducts' => function ($pq) {
                                $pq->where('is_active', true)
                                    ->with('variants')
                                    ->latest()
                                    ->take(4);
                            }
                        ]);
                }
            ])
            ->first();

        // If not found as parent, try as subcategory
        if (!$category) {
            $category = Category::where('slug', $slug)
                ->where('is_active', true)
                ->whereNotNull('parent_id')
                ->with('childProducts')
                ->first();
            // dd($subcategory->childProducts);
        }

        return view('storefront.category', compact('category'));
    }


    // SEO route: /product/{product}
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category', 'school');

        return view('storefront.product', [
            'product' => $product,
            // JSON-LD product schema (Section 14) — note: no publisher exposed.
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->name,
                'description' => $product->description,
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'PKR',
                    'price' => $product->effectivePrice(),
                    'availability' => $product->stock > 0
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

    public function categoriesIndex()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'children' => function ($q) {
                    $q->where('is_active', true);
                }
            ])
            ->get();

        return view('storefront.categories', compact('parentCategories'));
    }
}
