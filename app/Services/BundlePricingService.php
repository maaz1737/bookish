<?php

namespace App\Services;

use App\Models\Bundle;

/**
 * Bundle System (Section 7) auto-calculation engine.
 * total = Σ(book price × qty); final = total − (total × discount%).
 */
class BundlePricingService
{
    public function recalculate(Bundle $bundle): Bundle
    {
        $bundle->loadMissing('items.product');

        $total = $bundle->items->sum(function ($item) {
            $price = $item->product?->effectivePrice() ?? 0;
            return $price * $item->quantity;
        });

        $discountAmount = round($total * ($bundle->discount / 100), 2);

        $bundle->total_price = round($total, 2);
        $bundle->final_price = round($total - $discountAmount, 2);
        $bundle->save();

        return $bundle;
    }
}
