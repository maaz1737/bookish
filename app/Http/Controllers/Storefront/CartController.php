<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Session-based cart. Supports individual products AND full bundles,
 * with the ability to toggle individual books out of a bundle (Section 7).
 */
class CartController extends Controller
{
    public function index(Request $request)
    {
        return view('storefront.cart', ['cart' => $this->cart($request)]);
    }

    public function addProduct(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);
        $key = "product:{$product->id}";
        $qty = max(1, (int) $request->input('quantity', 1));
        $action = $request->input('action', 'add');

        if ($action === 'increase') {

            if (isset($cart[$key])) {
                $cart[$key]['quantity']++;
            }

        } elseif ($action === 'decrease') {

            if (isset($cart[$key])) {
                $cart[$key]['quantity']--;

                if ($cart[$key]['quantity'] <= 0) {
                    unset($cart[$key]);
                }
            }

        } else {

            $cart[$key] = [
                'type' => 'product',
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->effectivePrice(),
                'quantity' => ($cart[$key]['quantity'] ?? 0) + $qty,
                'slug' => $product->slug,
            ];

        }

        $request->session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => count(session('cart', []))
        ]);
    }

    public function addBundle(Request $request, Bundle $bundle)
    {
        $bundle->loadMissing('items.product');

        // Optional: which book ids to exclude (toggle individual books off)
        $excluded = (array) $request->input('exclude', []);

        $cart = $request->session()->get('cart', []);

        foreach ($bundle->items as $item) {
            if (in_array($item->product_id, $excluded)) {
                continue;
            }
            $key = "product:{$item->product_id}";

            $discountPct = (float) ($bundle->discount ?? 0);
            $originalPrice = (float) $item->product->effectivePrice();
            $discountedPrice = $originalPrice - ($originalPrice * ($discountPct / 100));

            $cart[$key] = [
                'type' => 'product',
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => round($discountedPrice, 2),
                'quantity' => ($cart[$key]['quantity'] ?? 0) + $item->quantity,
            ];
        }

        $request->session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Bundle added to cart.');
    }

    public function remove(Request $request, string $key)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$key]);
        $request->session()->put('cart', $cart);
        return back();
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back();
    }

    public function cart(Request $request): array
    {
        $items = $request->session()->get('cart', []);

        $productIds = collect($items)->pluck('id');

        $products = Product::whereIn('id', $productIds)
            ->get(['id', 'images', 'price', 'discount_price'])
            ->keyBy('id');

        foreach ($items as &$item) {
            $product = $products->get($item['id']);

            if ($product) {
                $item['image'] = $product->images;
                $item['price'] = $product->price;
                $item['discount_price'] = $product->discount_price;
            }
        }

        $total = collect($items)->sum(function ($item) {
            $price = $item['discount_price'] ?? $item['price'];
            return $price * $item['quantity'];
        });

        return [
            'items' => $items,
            'total' => $total,
        ];
    }



    public function json(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'items' => [],
                'total' => 0
            ]);
        }

        $productIds = collect($cart)->pluck('id');

        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');



        $items = [];
        $total = 0;

        foreach ($cart as $key => $item) {

            $product = $products[$item['id']] ?? null;
            if (!$product)
                continue;

            $qty = $item['quantity'];
            $price = $product->discount_price ?? $product->price;

            $items[] = [
                'key' => $key,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'quantity' => $qty,
                'image' => $product->images[0] ?? null,
                'subtotal' => $price * $qty,
            ];

            $total += $price * $qty;
        }

        $cart = session('cart', []);

        $totalQty = array_sum(array_column($cart, 'quantity')) ?? null;

        return response()->json([
            'items' => $items,
            'total' => $total,
            'total_count' => $totalQty ?? null,
        ]);
    }
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);


        $key = $request->key;
        $action = $request->action;

        if (!isset($cart[$key])) {
            return response()->json(['success' => false]);
        }

        if ($action === 'increase') {
            $cart[$key]['quantity']++;
        }

        if ($action === 'decrease') {
            $cart[$key]['quantity']--;

            if ($cart[$key]['quantity'] <= 0) {
                unset($cart[$key]);
            }
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }


    public function removeCartItem(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed successfully.',
        ]);
    }
}
