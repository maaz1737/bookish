<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Bundle;
use App\Services\BundlePricingService;

$bundles = Bundle::all();
foreach ($bundles as $b) {
    if ($b->discount > 100) {
        echo "Fixing bundle ID {$b->id} discount from {$b->discount} to 10\n";
        $b->discount = 10;
    }
    app(BundlePricingService::class)->recalculate($b);
    echo "Recalculated bundle ID {$b->id}: discount={$b->discount}%, total_price={$b->total_price}, final_price={$b->final_price}\n";
}
