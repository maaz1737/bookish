@extends('admin.layout')
@section('title', 'Products')
@section('content')
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Products</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.bulk.show') }}"
                class="bg-gray-800 text-white px-4 py-2 rounded flex items-center gap-1.5 hover:bg-gray-700">
                <i class="fa-solid fa-file-csv"></i> Bulk Upload
            </a>
            <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New
                Product</a>
        </div>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk.destroy') }}"
        onsubmit="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
        @csrf
        @method('DELETE')

        <div class="flex justify-end mb-3">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Selected</button>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="w-20 px-1">
                            <input type="checkbox" data-bulk-select-all class="rounded border-gray-300">
                            Select
                        </th>
                        <th class="w-20 p-3">Image</th>
                        <th class="w-64 p-3">Name</th>
                        <th class="w-40 p-3">Category</th>
                        <th class="w-40 p-3">Publisher</th>
                        <th class="w-28 p-3">Price</th>
                        <th class="w-24 p-3">Stock</th>
                        <th class="w-28 p-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($products as $p)
                        <tr>
                            <td class="px-1">
                                <input type="checkbox" name="selected[]" value="{{ $p->id }}" data-bulk-select-item
                                    class="rounded border-gray-300">
                            </td>
                            <td class="w-16 h-16 p-3"
                                style="background: url({{ $p->imageUrl() }});background-repeat:no-repeat;background-size:cover;background-position:center">
                            </td>
                            <td class="p-3">{{ $p->name }}</td>
                            <td class="p-3">{{  $p->subCategory?->name ?? $p->category?->name }}</td>
                            <td class="p-3 text-gray-400">{{ $p->publisher ?? '—' }}</td>
                            <td class="p-3">{{ number_format($p->effectivePrice()) }}</td>
                            <td class="p-3 {{ $p->isLowStock() ? 'text-red-500 font-semibold' : '' }}">{{ $p->stock }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.products.edit', $p) }}" class="text-indigo-600">Edit</a>
                                <button type="submit" form="delete-product-{{ $p->id }}" class="text-red-500"
                                    onclick="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    @foreach ($products as $p)
        <form id="delete-product-{{ $p->id }}" method="POST" action="{{ route('admin.products.destroy', $p) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
    <div class="mt-4">{{ $products->links() }}</div>

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