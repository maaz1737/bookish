<?php

use App\Models\Category;
use Illuminate\Support\Str;

echo "Seeding storefront categories...\n";

// Disable foreign key checks to truncate/rebuild cleanly if desired
// But since there might be product relationships, we will delete only categories matching our slugs or create them if they don't exist.

$hierarchy = [
    'School Essentials' => [
        'description' => 'Daily-use school products for students.',
        'icon' => '🎒',
        'subcategories' => [
            'School Bags' => ['description' => 'Durable bags for daily school use.', 'icon' => '🎒'],
            'Water Bottles' => ['description' => 'Reusable bottles for school and travel.', 'icon' => '🥤'],
            'Lunch Boxes' => ['description' => 'Lunch boxes for kids and students.', 'icon' => '🍱'],
            'Geometry Boxes' => ['description' => 'Geometry and math tools for classes.', 'icon' => '📐'],
            'Pencil Boxes' => ['description' => 'Organized storage for pencils and pens.', 'icon' => '✏️'],
            'Stationery' => ['description' => 'Writing, drawing and classroom supplies.', 'icon' => '🖍️'],
            'Art Supplies' => ['description' => 'Colors, brushes and creative school items.', 'icon' => '🎨'],
            'Study Accessories' => ['description' => 'Useful accessories for daily learning.', 'icon' => '📚'],
        ]
    ],
    'Gifts & Decor' => [
        'description' => 'PAF gifts, decor pieces and thoughtful items.',
        'icon' => '🎁',
        'subcategories' => [
            'PAF Decoration Models' => ['description' => 'Premium PAF-themed decoration pieces.', 'icon' => '✈️'],
            'Jet Plane Models' => ['description' => 'Aircraft models for tables and shelves.', 'icon' => '🛩️'],
            'Gift Items' => ['description' => 'Thoughtful gifts for different occasions.', 'icon' => '🎁'],
            'Decoration Pieces' => ['description' => 'Decor items for office, home and school.', 'icon' => '🏆'],
        ]
    ],
    'Fragrances' => [
        'description' => 'Attar, perfumes and fragrance gift sets.',
        'icon' => '🧴',
        'subcategories' => [
            'Attar' => ['description' => 'Long-lasting attars for daily use.', 'icon' => '🧴'],
            'Perfumes' => ['description' => 'Premium perfumes for a signature feel.', 'icon' => '🌸'],
            'Fragrance Gift Sets' => ['description' => 'Gift-ready fragrance sets and packs.', 'icon' => '🎀'],
        ]
    ]
];

foreach ($hierarchy as $parentName => $parentData) {
    $parentSlug = Str::slug($parentName);
    
    // Find or create parent
    $parent = Category::where('slug', $parentSlug)->first();
    if (!$parent) {
        $parent = new Category();
    }
    
    $parent->name = $parentName;
    $parent->slug = $parentSlug;
    $parent->description = $parentData['description'];
    $parent->is_active = true;
    $parent->show_on_dashboard = true;
    $parent->save();
    
    echo "  Parent Category: {$parent->name} (ID: {$parent->id})\n";
    
    foreach ($parentData['subcategories'] as $subName => $subData) {
        $subSlug = Str::slug($subName);
        
        $sub = Category::where('slug', $subSlug)->first();
        if (!$sub) {
            $sub = new Category();
        }
        
        $sub->name = $subName;
        $sub->slug = $subSlug;
        $sub->description = $subData['description'];
        $sub->parent_id = $parent->id;
        $sub->is_active = true;
        $sub->show_on_dashboard = false; // subcategories shown in dropdown or category index
        $sub->save();
        
        echo "    - Subcategory: {$sub->name} (ID: {$sub->id})\n";
    }
}

echo "Seeding completed successfully!\n";
