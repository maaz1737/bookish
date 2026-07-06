<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Bundle;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // POST /api/orders — initialize a checkout session payload
    public function store(StoreOrderRequest $request)
    {
        $order = DB::transaction(function () use ($request) {
            $order = Order::create([
                'order_number'   => 'BK-'.now()->format('Y').'-'.Str::upper(Str::random(6)),
                'user_id'        => $request->user()?->id,
                'customer_name'  => $request->customer_name,
                'mobile'         => $request->mobile,
                'address'        => $request->address,
                'total_amount'   => 0,
                'payment_status' => 'pending',
                'order_status'   => 'pending_payment',
            ]);

            $total = 0;

            foreach ($request->items as $line) {
                if ($line['type'] === 'bundle') {
                    $bundle = Bundle::with('items.product')->find($line['id']);
                    if (! $bundle) continue;
                    $lineTotal = $bundle->final_price * $line['quantity'];
                    $total += $lineTotal;
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'bundle_id'  => $bundle->id,
                        'name'       => "Bundle #{$bundle->id}",
                        'unit_price' => $bundle->final_price,
                        'quantity'   => $line['quantity'],
                        'line_total' => $lineTotal,
                    ]);
                } else {
                    $product = Product::find($line['id']);
                    if (! $product) continue;
                    $unit = $product->effectivePrice();
                    $lineTotal = $unit * $line['quantity'];
                    $total += $lineTotal;
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'name'       => $product->name,
                        'unit_price' => $unit,
                        'quantity'   => $line['quantity'],
                        'line_total' => $lineTotal,
                    ]);
                }
            }

            $order->update(['total_amount' => $total]);
            return $order;
        });

        return response()->json($order->load('items'), 201);
    }
}
