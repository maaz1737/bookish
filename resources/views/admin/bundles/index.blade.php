@extends('admin.layout')
@section('title', 'Bundles')
@section('content')
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Bundles</h1>
        <a href="{{ route('admin.bundles.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New Bundle</a>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.bundles.bulk.destroy') }}"
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
                        <th class="p-3">
                            <label class="flex items-center gap-2 text-gray-700">
                                <input type="checkbox" data-bulk-select-all class="rounded border-gray-300">
                                <span>Select All</span>
                            </label>
                        </th>
                        <th class="p-3">Bundle Name</th>
                        <th class="p-3">School</th>
                        <th class="p-3">Class</th>
                        <th class="p-3">Products</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Discount</th>
                        <th class="p-3">Final Price</th>
                        <th class="p-3">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($bundles as $b)
                        @if ($b?->id)
                            <tr>
                                <td class="p-3">
                                    <input type="checkbox" name="selected[]" value="{{ $b->id }}" data-bulk-select-item class="rounded border-gray-300">
                                </td>
                                <td class="p-3 font-semibold text-gray-900">
                                    {{ $b->name ?: 'Unnamed Bundle' }}
                                </td>
                                <td class="p-3">
                                    {{ $b?->school?->name ?? 'Generic / Any School' }}
                                </td>

                                <td class="p-3">
                                    {{ $b?->schoolClass?->name ?? 'Generic / Any Class' }}
                                </td>

                                <td class="p-3">
                                    {{ $b?->items_count ?? 0 }} Items
                                </td>

                                <td class="p-3">
                                    {{ number_format($b?->total_price ?? 0) }} PKR
                                </td>

                                <td class="p-3 text-red-600 font-medium">
                                    {{ isset($b->discount) ? rtrim(rtrim($b->discount, '0'), '.') . '%' : '0%' }}
                                </td>

                                <td class="p-3 font-bold text-[#0a1f44]">
                                    {{ number_format($b?->final_price ?? 0) }} PKR
                                </td>

                                <td class="p-3">
                                    @if ($b->is_active)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-semibold">Active</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full font-semibold">Inactive</span>
                                    @endif
                                </td>

                                <td class="p-3 text-right space-x-2">
                                    <a href="{{ route('admin.bundles.edit', $b) }}" class="text-indigo-600 hover:text-indigo-900 font-medium mr-2">Edit</a>
                                    <button type="submit" form="delete-bundle-{{ $b->id }}" class="text-red-600 hover:text-red-800 font-medium"
                                        onclick="return confirm('Are you sure you want to delete the selected item(s)? This action cannot be undone.')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    @foreach ($bundles as $b)
        @if ($b?->id)
            <form id="delete-bundle-{{ $b->id }}" method="POST" action="{{ route('admin.bundles.destroy', $b->id) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    @endforeach

    <div class="mt-4">{{ $bundles->links() }}</div>

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
