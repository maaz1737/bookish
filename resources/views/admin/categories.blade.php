@extends('admin.layout')
@section('title', 'Categories')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Categories Catalog</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage book categories and catalog genres</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Category
        </a>
    </div>

    {{-- Bulk delete form --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.categories.bulk.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf @method('DELETE')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 bg-gray-50/70 border-b border-gray-100">
                <label class="flex items-center gap-2.5 text-xs font-bold text-gray-700 select-none cursor-pointer">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span>Select All Categories</span>
                </label>

                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($categories as $c)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50/60 transition-colors">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="selected[]" value="{{ $c->id }}" data-bulk-select-item class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">

                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center">
                                @if ($c->image)
                                    <img src="{{ app()->environment('production') ? url('storage/' . $c->image) : asset('storage/' . $c->image) }}"
                                         class="w-full h-full object-cover" alt="{{ $c->name }}">
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-gray-900 text-sm">
                                        {{ $c->name }}
                                    </h3>

                                    <span class="text-[10px] uppercase font-extrabold px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                        {{ ucfirst($c->type) }}
                                    </span>

                                    @if ($c->show_on_dashboard)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Visible
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                            Hidden
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ Str::limit($c->description, 70) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-gray-600 bg-gray-100 font-semibold px-2.5 py-1 rounded-lg">
                                {{ $c->products_count }} products
                            </span>

                            <a href="{{ route('admin.categories.edit', $c) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                Edit
                            </a>

                            <button type="submit" form="delete-category-{{ $c->id }}" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    @foreach ($categories as $c)
        <form id="delete-category-{{ $c->id }}" method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <div class="mt-4">
        {{ $categories->links() }}
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
