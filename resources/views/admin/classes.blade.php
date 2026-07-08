@extends('admin.layout')
@section('title', 'Classes')
@section('content')
    <h1 class="text-2xl font-bold mb-6">
        Classes</h1>
    <form method="POST" action="{{ route('admin.classes.store') }}" class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
        @csrf
        <select name="school_id" required class="border rounded px-3 py-2">
            @foreach ($schools as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
        <input name="name" placeholder="Class name e.g. Class 6" required class="border rounded px-3 py-2 flex-1">
        <input name="sort_order" type="number" placeholder="Order" class="border rounded px-3 py-2 w-24" required>
        <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
    </form>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.classes.bulk.destroy') }}"
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
            @foreach ($classes as $cl)
                <div class="flex items-center justify-between p-3 text-sm border-b">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="selected[]" value="{{ $cl->id }}" data-bulk-select-item class="rounded border-gray-300">
                        <span>
                            {{ $cl?->school?->name ?? 'No School Assigned' }}
                            —
                            {{ $cl?->name ?? 'Unnamed Class' }}
                        </span>
                    </div>

                    <div>
                        <a href="{{ route('admin.classes.edit', $cl->id) }}">Edit</a>
                        <button type="submit" form="delete-class-{{ $cl->id }}" class="text-red-500 hover:text-red-700 font-medium"
                            onclick="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    @foreach ($classes as $cl)
        <form id="delete-class-{{ $cl->id }}" method="POST" action="{{ route('admin.classes.destroy', $cl->id) }}" class="hidden">
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