@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold mb-1">Order {{ $order->order_number }}</h1>
    <p class="text-gray-500 mb-4">{{ $order->customer_name }} · {{ number_format($order->total_amount) }} PKR</p>
    <div class="space-y-1 text-sm">
        <div>Payment: <strong>{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}</strong></div>
        <div>Order: <strong>{{ ucfirst(str_replace('_',' ',$order->order_status)) }}</strong></div>
    </div>
    <ul class="mt-4 divide-y text-sm">
        @foreach ($order->items as $item)
            <li class="py-2 flex justify-between"><span>{{ $item->name }} ×{{ $item->quantity }}</span><span>{{ number_format($item->line_total) }} PKR</span></li>
        @endforeach
    </ul>
</div>
@endsection
