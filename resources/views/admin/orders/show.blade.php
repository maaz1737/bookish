@extends('admin.layout')
@section('title', 'Order')
@section('content')
    <h1 class="text-2xl font-bold mb-1">{{ $order->order_number }}</h1>
    <p class="text-gray-500 mb-6">{{ $order->customer_name }} · {{ $order->mobile }}</p>
    <div class="grid sm:grid-cols-3 gap-6">
        <div class="sm:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold mb-3">Items</h2>
            <ul class="divide-y text-sm">
                <img src="{{ asset('storage/' . $order->paymentProofs[0]->screenshot_path) }}" alt="">
                @foreach ($order->items as $item)
                    <li class="py-2 flex justify-between"><span>{{ $item->name }}
                            ×{{ $item->quantity }}</span><span>{{ number_format($item->line_total) }} PKR</span></li>
                @endforeach
            </ul>
            <div class="text-right font-bold mt-3">Total: {{ number_format($order->total_amount) }} PKR</div>
            <p class="text-sm text-gray-500 mt-4">Shipping: {{ $order->address }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold mb-3">Update status</h2>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PUT')
                <select name="order_status" class="w-full border rounded px-3 py-2 mb-3">
                    @foreach (['pending_payment', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->order_status == $s)>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-indigo-600 text-white py-2 rounded">Save</button>
            </form>
        </div>
    </div>
@endsection
