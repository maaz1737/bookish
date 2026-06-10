<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Module 10 — Finance (Super Admin only).
 * Gross revenue, daily/weekly/monthly trends, payment ratios, CSV export.
 */
class FinanceController extends Controller
{
    public function index()
    {
        $paid = Order::where('payment_status', 'paid');

        $daily = (clone $paid)->whereDate('paid_at', today())->sum('total_amount');
        $weekly = (clone $paid)->where('paid_at', '>=', now()->subWeek())->sum('total_amount');
        $monthly = (clone $paid)->where('paid_at', '>=', now()->subMonth())->sum('total_amount');
        $gross = (clone $paid)->sum('total_amount');

        $statusRatio = Order::select('payment_status', DB::raw('count(*) as c'))
            ->groupBy('payment_status')->pluck('c', 'payment_status');

        $trend = Order::where('payment_status', 'paid')
            ->where('paid_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(paid_at) as d, SUM(total_amount) as total')
            ->groupBy('d')->orderBy('d')->get();

        return view('admin.finance', compact('daily', 'weekly', 'monthly', 'gross', 'statusRatio', 'trend'));
    }

    public function export(): StreamedResponse
    {
        $filename = 'bookish-finance-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order #', 'Customer', 'Amount (PKR)', 'Payment Status', 'Order Status', 'Paid At']);
            Order::orderBy('id')->chunk(200, function ($orders) use ($out) {
                foreach ($orders as $o) {
                    fputcsv($out, [$o->order_number, $o->customer_name, $o->total_amount,
                        $o->payment_status, $o->order_status, $o->paid_at]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
