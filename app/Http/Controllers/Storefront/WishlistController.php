<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    private function getIdentifier()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id()];
        }
        return ['session_id' => session()->getId()];
    }

    public function index()
    {
        $identifier = $this->getIdentifier();
        
        $wishlistItems = Wishlist::where($identifier)
            ->with('product')
            ->latest()
            ->get();
            
        return view('storefront.wishlist', compact('wishlistItems'));
    }

    public function toggle(Request $request, Product $product)
    {
        $identifier = $this->getIdentifier();
        
        $item = Wishlist::where($identifier)
            ->where('product_id', $product->id)
            ->first();
            
        if ($item) {
            $item->delete();
            $inWishlist = false;
            $message = 'Product removed from wishlist!';
        } else {
            Wishlist::create(array_merge($identifier, [
                'product_id' => $product->id
            ]));
            $inWishlist = true;
            $message = 'Product added to wishlist!';
        }
        
        $count = Wishlist::where($identifier)->count();
        
        return response()->json([
            'success' => true,
            'inWishlist' => $inWishlist,
            'message' => $message,
            'count' => $count
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $identifier = $this->getIdentifier();
        
        $exists = Wishlist::where($identifier)
            ->where('product_id', $product->id)
            ->exists();
            
        if (!$exists) {
            Wishlist::create(array_merge($identifier, [
                'product_id' => $product->id
            ]));
        }
        
        $count = Wishlist::where($identifier)->count();
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'count' => $count
        ]);
    }

    public function remove(Request $request, Product $product)
    {
        $identifier = $this->getIdentifier();
        
        Wishlist::where($identifier)
            ->where('product_id', $product->id)
            ->delete();
            
        $count = Wishlist::where($identifier)->count();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
                'count' => $count
            ]);
        }
        
        return back()->with('success', 'Product removed from wishlist.');
    }

    public function count()
    {
        $identifier = $this->getIdentifier();
        $count = Wishlist::where($identifier)->count();
        return response()->json(['count' => $count]);
    }
}
