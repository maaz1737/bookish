<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'pendingProofs' => Order::where('payment_status', 'proof_submitted')->count(),
            'pendingOrders' => Order::where('order_status', 'pending_payment')->count(),
            'lowStock'      => Product::whereColumn('stock', '<=', 'low_stock_threshold')->count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Order::count(),
            'recentOrders'  => Order::latest()->take(6)->get(),
        ]);
    }
}
