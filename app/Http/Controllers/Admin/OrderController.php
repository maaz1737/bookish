<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('latestProof')
            ->when($request->filled('status'), fn($q) => $q->where('order_status', $request->status))
            ->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'paymentProofs');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'order_status' => ['required', Rule::in(['pending', 'shipped', 'delivered', 'returned'])],
            'payment_status' => ['required', Rule::in(['pending', 'paid'])],
        ]);

        $newStatus     = $data['order_status'];
        $isOut         = in_array($newStatus, ['shipped', 'delivered']);
        $alreadyAdj    = $order->stock_adjusted;

        if ($isOut && !$alreadyAdj) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
            $data['stock_adjusted'] = true;

        } elseif (!$isOut && $alreadyAdj) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            $data['stock_adjusted'] = false;
        }

        $order->update($data);
        return back()->with('success', 'Order status updated.');
    }
}
