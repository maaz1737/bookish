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
                    <th class="p-3">School</th>
                    <th class="p-3">Class</th>
                    <th class="p-3">Books</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Discount</th>
                    <th class="p-3">Final</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($bundles as $b)
                    @if ($b?->id)
                        <tr>
                            <td class="p-3">
                                {{ $b?->school?->name ?? 'No School Assigned' }}
                            </td>

                            <td class="p-3">
                                {{ $b?->schoolClass?->name ?? 'No Class Assigned' }}
                            </td>

                            <td class="p-3">
                                {{ $b?->items_count ?? 0 }}
                            </td>

                            <td class="p-3">
                                {{ number_format($b?->total_price ?? 0) }}
                            </td>

                            <td class="p-3">
                                {{ isset($b->discount) ? rtrim(rtrim($b->discount, '0'), '.') . '%' : '0%' }}
                            </td>

                            <td class="p-3 font-semibold">
                                {{ number_format($b?->final_price ?? 0) }}
                            </td>

                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.bundles.destroy', $b->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this bundle? This action cannot be undone.')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
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
