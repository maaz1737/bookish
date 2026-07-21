@extends('admin.layout')
@section('title', 'Schools')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Schools Directory</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage partner schools and syllabus affiliations</p>
            </div>
        </div>
    </div>

    {{-- Create Form --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h2 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New School
        </h2>
        <form method="POST" action="{{ route('admin.schools.store') }}" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
            @csrf
            <div class="flex-1 w-full">
                <label class="block text-xs font-semibold text-gray-700 mb-1">School Name</label>
                <input name="name" placeholder="e.g. Beaconhouse School System" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="w-full md:w-72">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Logo Emblem (Optional)</label>
                <input type="file" name="logo" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
            </div>
            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
                Add School
            </button>
        </form>
    </div>

    {{-- Bulk Delete & Schools List --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.schools.bulk.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf @method('DELETE')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 bg-gray-50/70 border-b border-gray-100">
                <label class="flex items-center gap-2.5 text-xs font-bold text-gray-700 select-none cursor-pointer">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span>Select All Schools</span>
                </label>

                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($schools as $s)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50/60 transition-colors">
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="selected[]" value="{{ $s->id }}" data-bulk-select-item class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">

                            @if ($s->logo)
                                <img src="{{ asset('storage/' . $s->logo) }}" alt="{{ $s->name }}" class="w-11 h-11 object-contain rounded-xl border border-gray-200 p-1 bg-white flex-shrink-0 shadow-xs">
                            @else
                                <div class="w-11 h-11 rounded-xl border border-gray-200 bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">
                                    {{ $s->name }}
                                </h3>
                                <div class="text-xs text-gray-400 mt-0.5 font-medium">
                                    {{ $s->classes_count }} classes configured
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-xs">
                            <a href="{{ route('admin.schools.edit', $s->slug) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                Edit
                            </a>

                            <button type="submit" form="delete-school-{{ $s->id }}" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition"
                                    onclick="return confirm('Are you sure you want to delete this school?')">
                                Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    @foreach ($schools as $s)
        <form id="delete-school-{{ $s->id }}" method="POST" action="{{ route('admin.schools.destroy', $s) }}" class="hidden">
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
