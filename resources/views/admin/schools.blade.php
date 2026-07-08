@extends('admin.layout')
@section('title', 'Schools')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Schools</h1>
    <form method="POST" action="{{ route('admin.schools.store') }}" enctype="multipart/form-data" class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row items-end gap-4 mb-6">
        @csrf
        <div class="flex-1 w-full">
            <label class="block text-xs font-semibold text-gray-500 mb-1">School Name</label>
            <input name="name" placeholder="School name" required class="border rounded px-3 py-2 w-full">
        </div>
        <div class="w-full md:w-64">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Logo Emblem (Optional)</label>
            <input type="file" name="logo" accept="image/*" class="border rounded px-3 py-1.5 w-full text-sm">
        </div>
        <button class="bg-indigo-600 text-white px-6 py-2 rounded h-[42px] font-semibold text-sm">Add School</button>
    </form>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.schools.bulk.destroy') }}"
        onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf
        @method('DELETE')

        <div class="flex justify-end mb-3">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Selected</button>
        </div>

        <div class="bg-white rounded-lg shadow divide-y">
            <div class="flex items-center justify-between p-3 bg-gray-50">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300">
                    <span>Select All</span>
                </label>
            </div>
            @foreach ($schools as $s)
                <div class="flex items-center justify-between p-3 text-sm">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="selected[]" value="{{ $s->id }}" data-bulk-select-item class="rounded border-gray-300">
                        @if ($s->logo)
                            <img src="{{ asset('storage/' . $s->logo) }}" alt="{{ $s->name }}" class="w-10 h-10 object-contain rounded border p-0.5 bg-slate-50">
                        @else
                            <div class="w-10 h-10 flex items-center justify-center rounded border bg-slate-100 text-gray-400">
                                <i class="fa-solid fa-school text-xs"></i>
                            </div>
                        @endif
                        <span>{{ $s->name }} <span class="text-gray-400">({{ $s->classes_count }} classes)</span></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.schools.edit', $s->slug) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                        <button type="submit" form="delete-school-{{ $s->id }}" class="text-red-500 hover:text-red-700 font-semibold"
                            onclick="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    @foreach ($schools as $s)
        <form id="delete-school-{{ $s->id }}" method="POST" action="{{ route('admin.schools.destroy', $s) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

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
