@extends('admin.layout')
@section('title', 'Products')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Products Catalog</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage books, pricing, inventory stock, and details</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.products.bulk.show') }}"
               class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-gray-900/10 active:scale-95">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                </svg>
                Bulk Upload
            </a>
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                New Product
            </a>
        </div>
    </div>

    {{-- Form Bulk Delete & Table --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf @method('DELETE')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 bg-gray-50/70 border-b border-gray-100">
                <label class="flex items-center gap-2.5 text-xs font-bold text-gray-700 select-none cursor-pointer">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span>Select All Products</span>
                </label>

                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3.5 w-12 text-center">Select</th>
                            <th class="px-4 py-3.5 w-16">Image</th>
                            <th class="px-6 py-3.5">Product Details</th>
                            <th class="px-4 py-3.5">Category</th>
                            <th class="px-4 py-3.5">Publisher</th>
                            <th class="px-4 py-3.5">Price</th>
                            <th class="px-4 py-3.5">Stock</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($products as $p)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $p->id }}" data-bulk-select-item class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                </td>
                                <td class="px-4 py-4">
                                    <div class="w-12 h-14 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-xs">
                                        <img src="{{ $p->imageUrl() }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-sm line-clamp-1">{{ $p->name }}</div>
                                    @if($p->sku)
                                        <div class="text-[11px] text-gray-400 font-mono mt-0.5">SKU: {{ $p->sku }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        {{ $p->subCategory?->name ?? $p->category?->name ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-gray-500 font-medium">
                                    {{ $p->publisher ?? '—' }}
                                </td>
                                <td class="px-4 py-4 font-extrabold text-gray-900">
                                    {{ number_format($p->effectivePrice()) }} PKR
                                </td>
                                <td class="px-4 py-4">
                                    @if($p->isLowStock())
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            {{ $p->stock }} low
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ $p->stock }} in stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $p) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                            Edit
                                        </a>
                                        <button type="submit" form="delete-product-{{ $p->id }}" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    @foreach ($products as $p)
        <form id="delete-product-{{ $p->id }}" method="POST" action="{{ route('admin.products.destroy', $p) }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    @endforeach

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bulk-delete-form');
        if (!form) return;

        const selectAll = form.querySelector('[data-bulk-select-all]');
        const items = form.querySelectorAll('[data-bulk-select-item]');

        if (!selectAll || !items.length) return;

        const refreshState = () => {
            const checkedCount = Array.from(items).filter((checkbox) => checkbox.checked).length;
            selectAll.checked = checkedCount > 0 && checkedCount === items.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < items.length;
        };

        selectAll.addEventListener('change', function () {
            items.forEach((checkbox) => checkbox.checked = selectAll.checked);
        });

        items.forEach((checkbox) => checkbox.addEventListener('change', refreshState));
        refreshState();
    });
</script>
@endsection