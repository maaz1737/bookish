<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Main category slugs (parent categories that aggregate sub-types)
    private const PARENT_SLUGS = ['books', 'uniforms', 'accessories'];

    // Maps each parent category slug → which sub-category slugs belong to it
    private const CATEGORY_GROUPS = [
        'bags-bottles' => ['bags', 'bottles'],
        'baby-wear'    => ['baby-wear'],
        'gifts'        => ['gifts'],
    ];

    // SEO route: /category/{slug}
    public function category(string $slug, Request $request)
    {
        // 1. Find the current category
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // 2. Start a base product query
        $query = Product::where('is_active', true);

        // 3. Determine which category IDs to include
        $isMainCategory = in_array($category->slug, self::PARENT_SLUGS);

        if ($isMainCategory) {
            // Show all products of the same type (e.g., all 'book' type categories)
            $categoryIds = Category::where('type', $category->type)->pluck('id')->toArray();
            $query->whereIn('category_id', $categoryIds);
        } else {
            // Specific category — fetch only its products
            $query->where('category_id', $category->id);
        }

        // 4. Filter by subcategory if passed (e.g. ?subcategory=english)
        if ($request->filled('subcategory')) {
            $subCategorySlug = $request->input('subcategory');
            $subCat = Category::where('slug', $subCategorySlug)->first();
            if ($subCat) {
                $query = Product::where('is_active', true)->where('category_id', $subCat->id);
            }
        }

        // 5. Filter by color keyword (e.g. ?color=navy)
        if ($request->filled('color')) {
            $color = strtolower($request->input('color'));
            $colorMap = [
                'navy'   => ['navy', '#0b1b47', 'blue-900'],
                'black'  => ['black', '#000000', '#000'],
                'purple' => ['purple', '#b95fb7'],
                'pink'   => ['pink', '#f4b6cb'],
                'blue'   => ['blue', '#2e63c8'],
                'teal'   => ['teal', 'green', '#1fa39a'],
                'red'    => ['red', '#e53e3e'],
                'white'  => ['white', '#ffffff'],
                'grey'   => ['grey', 'gray'],
            ];
            $searchTerms = $colorMap[$color] ?? [$color];
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('name', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%");
                }
            });
        }

        // 6. Sort by (popular | price_asc | price_desc | newest)
        $sort = $request->input('sort', 'popular');
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'popular':
            default:
                // Popular: order by stock (proxy for demand), then newest
                $query->orderBy('stock', 'desc')->latest();
                break;
        }

        // 7. Paginate (24 per page) with all query strings preserved
        $products = $query->paginate(12)->withQueryString();

        // 8. Load subcategories for the sidebar
        //    Logic: show subcategories relevant to the current category's type,
        //    but exclude the top-level parent slugs themselves.
        $subcategories = Category::where('type', $category->type)
            ->whereNotIn('slug', self::PARENT_SLUGS)
            ->where('is_active', true)
            ->get();

        return view('user.categories.categories', compact('category', 'products', 'subcategories', 'sort'));
    }

    // SEO route: /product/{product}
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category', 'school');

        return view('storefront.product', [
            'product' => $product,
            'jsonLd'  => [
                '@context'    => 'https://schema.org',
                '@type'       => 'Product',
                'name'        => $product->name,
                'description' => $product->description,
                'offers'      => [
                    '@type'        => 'Offer',
                    'priceCurrency'=> 'PKR',
                    'price'        => $product->effectivePrice(),
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
}
