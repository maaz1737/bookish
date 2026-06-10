@extends('admin.layout')
@section('title','Products')
@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New Product</a>
</div>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">Name</th><th class="p-3">Category</th><th class="p-3">Publisher</th>
            <th class="p-3">Price</th><th class="p-3">Stock</th><th class="p-3"></th>
        </tr></thead>
        <tbody class="divide-y">
        @foreach ($products as $p)
            <tr>
                <td class="p-3">{{ $p->name }}</td>
                <td class="p-3">{{ $p->category->name }}</td>
                <td class="p-3 text-gray-400">{{ $p->publisher ?? '—' }}</td>
                <td class="p-3">{{ number_format($p->effectivePrice()) }}</td>
                <td class="p-3 {{ $p->isLowStock() ? 'text-red-500 font-semibold' : '' }}">{{ $p->stock }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.products.edit', $p) }}" class="text-indigo-600">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')<button class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
