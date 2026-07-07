<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Parents and Subcategories exist and are correctly linked
        $uniformsParent = Category::updateOrCreate(
            ['slug' => 'uniforms'],
            [
                'name' => 'Uniforms',
                'description' => 'Official uniforms for boys, girls and school sessions.',
                'is_active' => true,
                'show_on_dashboard' => true,
            ]
        );

        $accessoriesParent = Category::updateOrCreate(
            ['slug' => 'accessories'],
            [
                'name' => 'Accessories',
                'description' => 'Quality school bags, water bottles, lunch boxes and stationery.',
                'is_active' => true,
                'show_on_dashboard' => true,
            ]
        );

        // Update shirts, bags, and bottles to link to their correct parent
        $shirtsCategory = Category::updateOrCreate(
            ['slug' => 'shirts'],
            [
                'name' => 'Shirts',
                'description' => 'School and uniform shirts in all sizes and materials.',
                'parent_id' => $uniformsParent->id,
                'is_active' => true,
                'show_on_dashboard' => false,
            ]
        );

        $bagsCategory = Category::updateOrCreate(
            ['slug' => 'bags'],
            [
                'name' => 'Bags',
                'description' => 'Ergonomic, spacious and trendy school bags for kids.',
                'parent_id' => $accessoriesParent->id,
                'is_active' => true,
                'show_on_dashboard' => false,
            ]
        );

        $bottlesCategory = Category::updateOrCreate(
            ['slug' => 'bottles'],
            [
                'name' => 'Bottles',
                'description' => 'BPA-free plastic and stainless steel water bottles.',
                'parent_id' => $accessoriesParent->id,
                'is_active' => true,
                'show_on_dashboard' => false,
            ]
        );

        // 2. Define the product datasets
        $datasets = [
            'shirts' => [
                'category_id' => $shirtsCategory->id,
                'items' => [
                    [
                        'name' => 'White School Shirt',
                        'price' => 800,
                        'discount_price' => 640,
                        'is_new' => false,
                        'has_variant' => true,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Blue Uniform Shirt',
                        'price' => 900,
                        'discount_price' => null,
                        'is_new' => true,
                        'has_variant' => true,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Premium Polo Shirt',
                        'price' => 1200,
                        'discount_price' => 1020,
                        'is_new' => false,
                        'has_variant' => true,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Cotton School Shirt',
                        'price' => 1000,
                        'discount_price' => 900,
                        'is_new' => false,
                        'has_variant' => true,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                ]
            ],
            'bags' => [
                'category_id' => $bagsCategory->id,
                'items' => [
                    [
                        'name' => 'Ergonomic School Bag',
                        'price' => 2500,
                        'discount_price' => 2000,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Junior School Backpack',
                        'price' => 1800,
                        'discount_price' => null,
                        'is_new' => true,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Waterproof School Bag',
                        'price' => 3200,
                        'discount_price' => 2720,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Cute Cartoon Backpack',
                        'price' => 1500,
                        'discount_price' => 1350,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1577733966973-d680bfa2ca11?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                ]
            ],
            'bottles' => [
                'category_id' => $bottlesCategory->id,
                'items' => [
                    [
                        'name' => 'Stainless Steel Bottle',
                        'price' => 1200,
                        'discount_price' => 960,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Insulated Kids Flask',
                        'price' => 1500,
                        'discount_price' => null,
                        'is_new' => true,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'BPA-Free Plastic Bottle',
                        'price' => 800,
                        'discount_price' => 680,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1608889175123-8ec330b86f84?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                    [
                        'name' => 'Sports Water Bottle',
                        'price' => 1000,
                        'discount_price' => 900,
                        'is_new' => false,
                        'has_variant' => false,
                        'unsplash_url' => 'https://images.unsplash.com/photo-1589362483234-c7367744710d?auto=format&fit=crop&w=400&h=400&q=80'
                    ],
                ]
            ],
        ];

        // 3. Loop and create products while downloading images
        foreach ($datasets as $catName => $data) {
            $catId = $data['category_id'];
            foreach ($data['items'] as $index => $item) {
                // Delete existing duplicate product to avoid clutter
                Product::where('name', $item['name'])->where('category_id', $catId)->delete();

                // Generate a unique local filename
                $imageFilename = 'unsplash_' . $catName . '_' . ($index + 1) . '.jpg';
                $localPath = storage_path('app/public/products/' . $imageFilename);

                // Download the image
                $downloaded = false;
                try {
                    // Set timeout and request options
                    $opts = [
                        'http' => [
                            'method' => 'GET',
                            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36\r\n",
                            'timeout' => 10,
                        ]
                    ];
                    $context = stream_context_create($opts);
                    $imageContent = file_get_contents($item['unsplash_url'], false, $context);
                    if ($imageContent !== false) {
                        file_put_contents($localPath, $imageContent);
                        $downloaded = true;
                    }
                } catch (\Exception $e) {
                    // Fail silently, fallback image will be used
                }

                // If download failed, use a fallback image from already existing files
                $finalImage = $downloaded ? 'products/' . $imageFilename : 'products/0RtmiNpqcj27tFjbAK858AuXA6ZH2YnmN6CglAxw.jpg';

                $slug = Str::slug($item['name']) . '-' . Str::random(5);
                $product = Product::create([
                    'name' => $item['name'],
                    'slug' => $slug,
                    'category_id' => $catId,
                    'price' => $item['price'],
                    'discount_price' => $item['discount_price'],
                    'stock' => 100,
                    'low_stock_threshold' => 5,
                    'description' => 'Premium high-quality handpicked ' . strtolower($item['name']) . ' from our collection.',
                    'images' => [$finalImage],
                    'is_active' => true,
                    'is_best_seller' => !$item['is_new'] && ($item['discount_price'] !== null),
                ]);

                if ($item['has_variant']) {
                    // Seed size variants
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(substr($item['name'], 0, 3)) . '-S',
                        'price' => $item['discount_price'] ?? $item['price'],
                        'stock' => 50,
                    ]);
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(substr($item['name'], 0, 3)) . '-M',
                        'price' => ($item['discount_price'] ?? $item['price']) + 50,
                        'stock' => 50,
                    ]);
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(substr($item['name'], 0, 3)) . '-L',
                        'price' => ($item['discount_price'] ?? $item['price']) + 100,
                        'stock' => 50,
                    ]);
                }
            }
        }
    }
}
