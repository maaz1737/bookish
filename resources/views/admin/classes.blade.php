@extends('admin.layout')
@section('title', 'Classes')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Academic Classes</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage school grades, levels, and sort ordering</p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h2 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Class Grade
        </h2>
        <form method="POST" action="{{ route('admin.classes.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            @csrf
            <div class="sm:col-span-5">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Affiliated School</label>
                <select name="school_id" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                    @foreach ($schools as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Class Name</label>
                <input name="name" placeholder="e.g. Class 6 / Grade VI" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
            <div class="sm:col-span-1">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Order</label>
                <input name="sort_order" type="number" placeholder="1" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-center">
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
                    Add Class
                </button>
            </div>
        </form>
    </div>

    {{-- Classes List --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.classes.bulk.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf @method('DELETE')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 bg-gray-50/70 border-b border-gray-100">
                <label class="flex items-center gap-2.5 text-xs font-bold text-gray-700 select-none cursor-pointer">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span>Select All Classes</span>
                </label>

                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($classes as $cl)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50/60 transition-colors">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="selected[]" value="{{ $cl->id }}" data-bulk-select-item class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">

                            <div>
                                <span class="font-bold text-gray-900 text-sm">
                                    {{ $cl?->name ?? 'Unnamed Class' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-2 font-medium">
                                    <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700">🏫 {{ $cl?->school?->name ?? 'No School' }}</span>
                                    @if($cl->sort_order)
                                        <span class="text-gray-400">• Sort Order: {{ $cl->sort_order }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-xs">
                            <a href="{{ route('admin.classes.edit', $cl->id) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                Edit
                            </a>

                            <button type="submit" form="delete-class-{{ $cl->id }}" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                    onclick="return confirm('Are you sure you want to delete this class?')">
                                Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    @foreach ($classes as $cl)
        <form id="delete-class-{{ $cl->id }}" method="POST" action="{{ route('admin.classes.destroy', $cl->id) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
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