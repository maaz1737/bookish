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


    // SEO route: /category/{slug}
    public function category(string $slug)
    {
        $sort = request('sort', 'latest');

        // Helper closure to apply sort order to a product query
        $applySortClosure = function ($q) use ($sort) {
            $q->where('is_active', true)->with('variants');
            match ($sort) {
                'price_asc'  => $q->orderBy('price', 'asc'),
                'price_desc' => $q->orderBy('price', 'desc'),
                'name_asc'   => $q->orderBy('name', 'asc'),
                default      => $q->latest(),
            };
        };

        // Try as a parent category first
        $category = Category::whereNull('parent_id')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'products' => function ($q) use ($applySortClosure) {
                    $applySortClosure($q);
                    $q->whereNull('sub_category_id');
                },
                'children' => function ($q) use ($applySortClosure) {
                    $q->where('is_active', true)
                        ->with([
                            'childProducts' => function ($pq) use ($applySortClosure) {
                                $applySortClosure($pq);
                                $pq->take(4);
                            }
                        ]);
                },
            ])
            ->first();

        // If not found as parent, try as subcategory (leaf)
        if (!$category) {
            $category = Category::where('slug', $slug)
                ->where('is_active', true)
                ->whereNotNull('parent_id')
                ->with([
                    'childProducts' => function ($q) use ($applySortClosure) {
                        $applySortClosure($q);
                    },
                ])
                ->first();
        }

        abort_if(!$category, 404);

        return view('storefront.category', compact('category', 'sort'));
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
                'products' => function ($q) {
                    $q->where('is_active', true)->with('variants')->latest()->take(3);
                },
                'children' => function ($q) {
                    $q->where('is_active', true)
                        ->with([
                            'childProducts' => function ($pq) {
                                $pq->where('is_active', true)->with('variants')->latest()->take(3);
                            }
                        ]);
                }
            ])
            ->get();

        $allProducts = Product::active()
            ->with('variants')
            ->latest()
            ->take(3)
            ->get();

        return view('storefront.categories', compact('parentCategories', 'allProducts'));
    }
}
