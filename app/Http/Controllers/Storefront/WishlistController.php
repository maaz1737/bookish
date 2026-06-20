<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        $wishlist = $request->session()->get('wishlist', []);

        if (in_array($product->id, $wishlist)) {
            $wishlist = array_values(array_diff($wishlist, [$product->id]));
            $msg = 'Removed from wishlist.';
        } else {
            $wishlist[] = $product->id;
            $msg = 'Added to wishlist.';
        }

        $request->session()->put('wishlist', $wishlist);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'in_wishlist' => in_array($product->id, $wishlist),
                'count' => count($wishlist)
            ]);
        }

        return back()->with('success', $msg);
    }
}
