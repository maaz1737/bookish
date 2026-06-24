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

        $cart[$key] = [
            'type' => 'product',
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->effectivePrice(),
            'quantity' => ($cart[$key]['quantity'] ?? 0) + $qty,
        ];

        $request->session()->put('cart', $cart);
        return back()->with('success', 'Added to cart.');
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
            $cart[$key] = [
                'type' => 'product',
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->effectivePrice(),
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

    private function cart(Request $request): array
    {
        $items = $request->session()->get('cart', []);

        $productIds = collect($items)->pluck('id');

        $products = Product::whereIn('id', $productIds)
            ->pluck('images', 'id');

        foreach ($items as &$item) {
            $item['image'] = $products[$item['id']] ?? null;
        }

        $total = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        return [
            'items' => $items,
            'total' => $total
        ];
    }
}
