@extends('admin.layout')
@section('title','Inventory')
@section('content')
<h1 class="text-2xl font-bold mb-6">Inventory</h1>
<div class="bg-white rounded-lg shadow overflow-x-auto">
<table class="w-full text-sm"><thead class="bg-gray-50 text-left"><tr>
<th class="p-3">Product</th><th class="p-3">Stock</th><th class="p-3">Threshold</th><th class="p-3"></th></tr></thead>
<tbody class="divide-y">
@foreach ($products as $p)
<tr class="{{ $p->isLowStock() ? 'bg-red-50' : '' }}">
    <td class="p-3">{{ $p->name }}</td>
    <td colspan="3" class="p-3">
        <form method="POST" action="{{ route('admin.inventory.update', $p) }}" class="flex gap-2 items-center">
            @csrf @method('PUT')
            <input name="stock" type="number" value="{{ $p->stock }}" class="border rounded px-2 py-1 w-24">
            <input name="low_stock_threshold" type="number" value="{{ $p->low_stock_threshold }}" class="border rounded px-2 py-1 w-24">
            <button class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">Update</button>
            @if($p->isLowStock())<span class="text-red-500 text-xs">Low stock</span>@endif
        </form>
    </td>
</tr>
@endforeach
</tbody></table></div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
