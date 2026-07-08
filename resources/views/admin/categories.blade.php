@extends('admin.layout')
@section('title', 'Categories')
@section('content')
    <div class="flex items-center justify-between px-4 mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>

        <a href="{{ route('admin.categories.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg transition">
            Add New Category
        </a>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.categories.bulk.destroy') }}"
        onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf
        @method('DELETE')

        <div class="flex justify-end mb-3 px-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Selected</button>
        </div>

        <div class="bg-white rounded-xl shadow divide-y">
            <div class="flex items-center justify-between p-4 bg-gray-50">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" data-bulk-select-all class="rounded border-gray-300">
                    <span>Select All</span>
                </label>
            </div>

            @foreach ($categories as $c)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <input type="checkbox" name="selected[]" value="{{ $c->id }}" data-bulk-select-item class="rounded border-gray-300">

                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                            @if ($c->image)
                                <img src="{{ app()->environment('production') ? url('storage/' . $c->image) : asset('storage/' . $c->image) }}"
                                    class="w-full h-full object-cover" alt="{{ $c->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                    No Img
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-800">
                                    {{ $c->name }}
                                </h3>

                                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                    {{ ucfirst($c->type) }}
                                </span>

                                @if ($c->show_on_dashboard)
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">
                                        Visible
                                    </span>
                                @else
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">
                                        Hidden
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ Str::limit($c->description, 60) }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                            {{ $c->products_count }} products
                        </span>

                        <a href="{{ route('admin.categories.edit', $c) }}" class="text-indigo-600 hover:underline">
                            Edit
                        </a>

                        <button type="submit" form="delete-category-{{ $c->id }}" class="text-red-500 hover:underline"
                            onclick="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
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
