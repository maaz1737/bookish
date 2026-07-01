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

        $oldStatus = $order->order_status;
        $newStatus = $data['order_status'];

        $wasOut = in_array($oldStatus, ['shipped', 'delivered']);
        $isOut = in_array($newStatus, ['shipped', 'delivered']);

        if (!$wasOut && $isOut) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        } elseif ($wasOut && !$isOut) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        $order->update($data);
        return back()->with('success', 'Order status updated.');
    }
}
