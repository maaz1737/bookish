<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Banner;

// Truncate existing banners to start fresh with clean Unsplash images
Banner::truncate();

$banners = [
    [
        'title' => 'Discover the World of Books',
        'image_path' => 'https://images.unsplash.com/photo-1513001900722-370f803f498d?auto=format&fit=crop&w=1600&h=650&q=80',
        'link' => '/category/books',
        'is_active' => true,
        'order' => 1,
    ],
    [
        'title' => 'Premium School Uniforms & Durable Bags',
        'image_path' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=1600&h=650&q=80',
        'link' => '/category/uniforms',
        'is_active' => true,
        'order' => 2,
    ],
    [
        'title' => 'Adorable Baby Wear & Memorable Gifts',
        'image_path' => 'https://images.unsplash.com/photo-1515488042361-404e9250afef?auto=format&fit=crop&w=1600&h=650&q=80',
        'link' => '/category/baby-wear',
        'is_active' => true,
        'order' => 3,
    ],
];

foreach ($banners as $b) {
    Banner::create([
        'title' => $b['title'],
        'image_path' => $b['image_path'],
        'link' => $b['link'],
        'is_active' => $b['is_active'],
        'order' => $b['order'],
    ]);
}

echo "Banners successfully seeded with Unsplash images!" . PHP_EOL;
