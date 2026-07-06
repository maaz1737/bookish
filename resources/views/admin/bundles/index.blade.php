@extends('admin.layout')
@section('title', 'Bundles')
@section('content')
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Bundles</h1>
        <a href="{{ route('admin.bundles.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New Bundle</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
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
                                <form method="POST" action="{{ route('admin.bundles.destroy', $b->id) }}" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this bundle? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $bundles->links() }}</div>
@endsection
