@extends('admin.layout')
@section('title', 'Inventory')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Stock & Inventory Management</h1>
                <p class="text-xs text-gray-500 mt-0.5">Monitor stock levels and configure low-stock alerts</p>
            </div>
        </div>
    </div>

    {{-- Inventory Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Product Name</th>
                        <th class="px-6 py-3.5">Current Stock</th>
                        <th class="px-6 py-3.5">Low Stock Threshold</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Update Inventory</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($products as $p)
                        <tr class="{{ $p->isLowStock() ? 'bg-rose-50/40' : 'hover:bg-gray-50/50' }} transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 text-sm">
                                {{ $p->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-sm {{ $p->isLowStock() ? 'text-rose-600' : 'text-gray-900' }}">
                                    {{ $p->stock }} units
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-medium">
                                {{ $p->low_stock_threshold }} units
                            </td>
                            <td class="px-6 py-4">
                                @if($p->isLowStock())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-700 border border-rose-200">
                                        ⚠️ Low Stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ In Stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.inventory.update', $p) }}" class="inline-flex items-center gap-2 justify-end">
                                    @csrf @method('PUT')
                                    <div>
                                        <input name="stock" type="number" min="0" value="{{ $p->stock }}" placeholder="Stock" title="Current Stock" class="border border-gray-200 rounded-lg px-2.5 py-1.5 w-20 text-xs text-center focus:ring-2 focus:ring-indigo-500 outline-none">
                                    </div>
                                    <div>
                                        <input name="low_stock_threshold" min="0" type="number" value="{{ $p->low_stock_threshold }}" placeholder="Threshold" title="Low Stock Threshold" class="border border-gray-200 rounded-lg px-2.5 py-1.5 w-20 text-xs text-center focus:ring-2 focus:ring-indigo-500 outline-none">
                                    </div>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1.5 rounded-lg text-xs transition shadow-sm active:scale-95">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
