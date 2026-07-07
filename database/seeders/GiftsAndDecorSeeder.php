<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GiftsAndDecorSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Parent Category: Gift & Decor
        $parent = Category::updateOrCreate(
            ['slug' => 'gifts-decor'],
            [
                'name' => 'Gift & Decor',
                'description' => 'Discover thoughtful gifts, metal crafts, wall décor, and collectible souvenirs.',
                'image' => 'categories/gifts-decor-hero.png',
                'is_active' => true,
                'show_on_dashboard' => true,
            ]
        );

        // 2. Create Subcategories
        $subcategories = [
            'metal-craft' => [
                'name' => 'Metal Craft',
                'description' => 'Exquisite metal lanterns, pen holders, sculptures and miniature cars.',
            ],
            'airforce-decoration' => [
                'name' => 'Airforce Decoration',
                'description' => 'Official airforce aircraft models, emblems, and desk decoration pieces.',
            ],
            'wall-art' => [
                'name' => 'Wall Art',
                'description' => 'Beautiful metal tree wall art, calligraphy, and abstract designs.',
            ],
            'key-rings' => [
                'name' => 'Key Rings',
                'description' => 'Durable airplane keyrings, emblems, and souvenir key chains.',
            ],
        ];

        $subCategoryModels = [];
        foreach ($subcategories as $slug => $data) {
            $subCategoryModels[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'parent_id' => $parent->id,
                    'is_active' => true,
                    'show_on_dashboard' => false,
                ]
            );
        }

        // 3. Helper to create products
        $createProduct = function ($name, $category_id, $price, $discount_price, $is_new, $imageName, $has_variant = false) {
            $slug = Str::slug($name) . '-' . Str::random(5);
            
            // Clean up any existing product with the same name under this category to avoid clutter
            Product::where('name', $name)->where('category_id', $category_id)->delete();

            $product = Product::create([
                'name' => $name,
                'slug' => $slug,
                'category_id' => $category_id,
                'price' => $price,
                'discount_price' => $discount_price,
                'stock' => 100,
                'low_stock_threshold' => 5,
                'description' => 'Premium high-quality handpicked item matching our collection.',
                'images' => ['products/' . $imageName], // Use a valid unique seeded image path
                'is_active' => true,
                'is_best_seller' => !$is_new && ($discount_price !== null),
            ]);

            if ($has_variant) {
                // Seed some variants
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => strtoupper(substr($name, 0, 3)) . '-VAR1',
                    'price' => $discount_price ?? $price,
                    'stock' => 50,
                ]);
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => strtoupper(substr($name, 0, 3)) . '-VAR2',
                    'price' => ($discount_price ?? $price) + 100,
                    'stock' => 50,
                ]);
            }

            return $product;
        };

        // Seed Metal Craft products
        $mcId = $subCategoryModels['metal-craft']->id;
        $createProduct('Decorative Metal Lantern', $mcId, 2000, 1600, false, '0RtmiNpqcj27tFjbAK858AuXA6ZH2YnmN6CglAxw.jpg');
        $createProduct('Metal Pen Holder', $mcId, 850, null, true, '0bzqBxn4oraStnnc5Wuyn6cFm2zJRtJctDN45dpu.jpg');
        $createProduct('Globe Metal Sculpture', $mcId, 3000, 2550, false, '1KmUYOLcCHrMcKN7X8yzPBm9ZI2EvBOLOeFBVlOK.jpg');
        $createProduct('Vintage Car Miniature', $mcId, 1500, 1350, false, '34EmUquedLxpIPtMHw0uXtRlVQqAmvV4qR3HqbzH.jpg');

        // Seed Airforce Decoration products
        $adId = $subCategoryModels['airforce-decoration']->id;
        $createProduct('PAF JF-17 Thunder Model', $adId, 2500, 2200, false, '3gzY8GDdH0ZGi9qR2YaGNoNKAkcbsmHIEjsnNs1e.jpg');
        $createProduct('Aircraft Desk Piece', $adId, 1650, null, true, '6LU4noHAxTslA0Ggvfc0gURexoedJRXIhwuwID9u.jpg');
        $createProduct('Airforce Emblem Décor', $adId, 2300, 1950, false, '6RxyDTDNqocyGGv4vexkrqJaZefqAqVLAP9cfFkt.jpg');
        $createProduct('PAF Souvenir Shield', $adId, 1500, 1350, false, '7IDXvV9SRCQSFXGSbnZdZvhQemq2lioKtiwxmsbw.jpg');

        // Seed Wall Art products
        $waId = $subCategoryModels['wall-art']->id;
        $createProduct('Metal Tree Wall Art', $waId, 3000, 2400, false, '7QraRFNnKgPMGOkRdujK6eUknRBOvFum7lXLIQJs.jpg');
        $createProduct('Crescent Moon Wall Décor', $waId, 1450, null, true, '8DtHQYgwGljBpSORR9iubxsvvc2GjrdWdrvG9KQk.png');
        $createProduct('Islamic Calligraphy Wall Art', $waId, 2400, 2050, false, '8dVlDbMrJUJqkuDKFV0c2EeJn0jJVfhOk2zBJSUo.jpg');
        $createProduct('Abstract Metal Wall Art', $waId, 2000, 1800, false, '8l7GuflWyUgeZttXIgkrdMeVslVVzQnzzIJQ4uUQ.jpg');

        // Seed Key Rings products
        $krId = $subCategoryModels['key-rings']->id;
        $createProduct('Airplane Keyring', $krId, 450, null, true, '9YiVQ1cB1LBUzfMx3nViFoxyi0TEo7UykJESCvw3.jpg');
        $createProduct('Pakistan Airforce Keychain', $krId, 600, 550, false, 'BzuIKQk5N0E6T6p1l21PmhzRsIaqd5XLZ3eFUte0.jpg');
        $createProduct('Metallic Souvenir Keyring', $krId, 500, null, true, 'CXPRIbNPTfNajytlwpMsMu5AgHn1pnbxrloSFqEQ.jpg');
        $createProduct('Jet Fighter Keychain', $krId, 500, 450, false, 'D58tZCXDrwtufKBW22gxh42FZU7H7cJhqqHoT9Ir.jpg');

        // Seed Direct Parent products (These will have variants to show "View Options")
        $pId = $parent->id;
        $createProduct('Premium Gift Box', $pId, 1100, 950, false, 'G1zPWEJxdzth4SJ1CAOOInQik7SLszdpyFdj9R4g.jpg', true);
        $createProduct('Airforce Souvenir Mug', $pId, 750, null, true, 'G2aSqtbAgJN4mBDKDiEcO6gdImCDKzQqfKzoPtvI.jpg', true);
        $createProduct('Decorative Table Piece', $pId, 2000, 1800, false, 'HNQQbCLzKUcdNri14vgeP3cXoysFpn6oidPY1HHx.jpg', true);
        $createProduct('Premium Gift Set', $pId, 2650, null, true, 'IhoKvsQelTEESPKynLxmctaygbDFfPsGZKRIvSy2.jpg', true);
    }
}
