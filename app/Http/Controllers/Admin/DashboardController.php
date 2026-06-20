<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards ──────────────────────────────────────────────
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('order_status', 'pending_payment')->count();
        $processingOrders = Order::where('order_status', 'processing')->count();
        $deliveredOrders  = Order::where('order_status', 'delivered')->count();

        $pendingProofs  = Order::where('payment_status', 'proof_submitted')->count();
        $totalProducts  = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStock       = Product::whereColumn('stock', '<=', 'low_stock_threshold')->count();
        $totalCategories = Category::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // ── Revenue ─────────────────────────────────────────────────
        $grossRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $todayRevenue = Order::where('payment_status', 'paid')
                            ->whereDate('paid_at', today())->sum('total_amount');
        $monthRevenue = Order::where('payment_status', 'paid')
                            ->where('paid_at', '>=', now()->startOfMonth())->sum('total_amount');

        // ── 7-Day Revenue Trend ──────────────────────────────────────
        $revenueTrend = Order::where('payment_status', 'paid')
            ->where('paid_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(paid_at) as day, SUM(total_amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        // Fill in missing days with 0
        $trendLabels = [];
        $trendData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = now()->subDays($i)->format('D'); // Mon, Tue…
            $trendData[]   = (float) ($revenueTrend[$date] ?? 0);
        }

        // ── Order Status Breakdown ───────────────────────────────────
        $orderStatusCounts = Order::select('order_status', DB::raw('count(*) as c'))
            ->groupBy('order_status')
            ->pluck('c', 'order_status');

        // ── Recent Orders ────────────────────────────────────────────
        $recentOrders = Order::with('latestProof')
            ->latest()->take(8)->get();

        // ── Top Products by stock sold (proxy: low stock = popular) ──
        $topProducts = Product::where('is_active', true)
            ->orderBy('stock', 'asc')
            ->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'pendingOrders', 'processingOrders', 'deliveredOrders',
            'pendingProofs', 'totalProducts', 'activeProducts', 'lowStock',
            'totalCategories', 'totalCustomers',
            'grossRevenue', 'todayRevenue', 'monthRevenue',
            'trendLabels', 'trendData',
            'orderStatusCounts', 'recentOrders', 'topProducts'
        ));
    }
}
