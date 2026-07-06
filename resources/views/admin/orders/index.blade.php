@extends('admin.layout')
@section('title','Orders')
@section('content')
<h1 class="text-2xl font-bold mb-6">Orders</h1>
<div class="bg-white rounded-lg shadow overflow-x-auto">
<table class="w-full text-sm"><thead class="bg-gray-50 text-left"><tr>
<th class="p-3">Order #</th><th class="p-3">Customer</th><th class="p-3">Amount</th>
<th class="p-3">Payment</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead>
<tbody class="divide-y">
@foreach ($orders as $o)
<tr>
    <td class="p-3 font-mono">{{ $o->order_number }}</td>
    <td class="p-3">{{ $o->customer_name }}<br><span class="text-gray-400">{{ $o->mobile }}</span></td>
    <td class="p-3">{{ number_format($o->total_amount) }} PKR</td>
    <td class="p-3"><span class="px-2 py-1 rounded text-xs bg-gray-100">{{ str_replace('_',' ',$o->payment_status) }}</span></td>
    <td class="p-3">{{ str_replace('_',' ',$o->order_status) }}</td>
    <td class="p-3"><a href="{{ route('admin.orders.show', $o) }}" class="text-indigo-600">View</a></td>
</tr>
@endforeach
</tbody></table></div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
