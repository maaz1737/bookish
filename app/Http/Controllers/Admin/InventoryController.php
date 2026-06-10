<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderByRaw('stock <= low_stock_threshold DESC')
            ->orderBy('stock')->paginate(25);

        return view('admin.inventory', compact('products'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $data = $request->validate([
            'stock'               => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
        ]);
        $product->update($data);
        return back()->with('success', 'Stock updated.');
    }
}
