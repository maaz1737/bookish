@extends('admin.layout')
@section('title', 'Bundles')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Syllabus Bundles</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage school-wise class bundles and package discounts</p>
            </div>
        </div>
        <a href="{{ route('admin.bundles.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            New Bundle
        </a>
    </div>

    {{-- Form Bulk Delete & Table --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.bundles.bulk.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf @method('DELETE')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 bg-gray-50/70 border-b border-gray-100">
                <label class="flex items-center gap-2.5 text-xs font-bold text-gray-700 select-none cursor-pointer">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span>Select All Bundles</span>
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
                            <th class="px-6 py-3.5">Bundle Name</th>
                            <th class="px-4 py-3.5">School</th>
                            <th class="px-4 py-3.5">Class</th>
                            <th class="px-4 py-3.5">Items</th>
                            <th class="px-4 py-3.5">Discount</th>
                            <th class="px-4 py-3.5">Final Price</th>
                            <th class="px-4 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($bundles as $b)
                            @if ($b?->id)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-4 text-center">
                                        <input type="checkbox" name="selected[]" value="{{ $b->id }}" data-bulk-select-item class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                                        {{ $b->name ?: 'Unnamed Bundle' }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 font-medium">
                                        {{ $b?->school?->name ?? 'Any School' }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 font-medium">
                                        {{ $b?->schoolClass?->name ?? 'Any Class' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700">
                                            {{ $b?->items_count ?? 0 }} Items
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-bold text-rose-600">
                                        {{ isset($b->discount) ? rtrim(rtrim($b->discount, '0'), '.') . '%' : '0%' }}
                                    </td>
                                    <td class="px-4 py-4 font-extrabold text-indigo-950 text-sm">
                                        {{ number_format($b?->final_price ?? 0) }} PKR
                                    </td>
                                    <td class="px-4 py-4">
                                        @if ($b->is_active)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700 border border-gray-200">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.bundles.edit', $b) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                                Edit
                                            </a>
                                            <button type="submit" form="delete-bundle-{{ $b->id }}" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                                    onclick="return confirm('Are you sure you want to delete this bundle?')">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    @foreach ($bundles as $b)
        @if ($b?->id)
            <form id="delete-bundle-{{ $b->id }}" method="POST" action="{{ route('admin.bundles.destroy', $b->id) }}" class="hidden">
                @csrf @method('DELETE')
            </form>
        @endif
    @endforeach

    <div class="mt-4">
        {{ $bundles->links() }}
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
