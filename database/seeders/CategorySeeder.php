<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Books', 'book'],
            ['Uniforms', 'uniform'],
            ['Accessories', 'accessory'],
            // Uniform sub-categories (Section 6.2)
            ['Shirts', 'uniform'],
            ['Pants', 'uniform'],
            ['Skirts', 'uniform'],
            ['Sweaters', 'uniform'],
            ['Shoes', 'uniform'],
            ['Ties', 'uniform'],
            // Accessory items (Section 6.3)
            ['Bags', 'accessory'],
            ['Bottles', 'accessory'],
            ['Lunch Boxes', 'accessory'],
            ['Gifts', 'accessory'],
        ];

        foreach ($categories as [$name, $type]) {
            Category::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}
