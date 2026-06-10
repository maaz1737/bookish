@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $category->name }}</h1>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    @forelse ($products as $product)
        <a href="{{ route('product.show', $product) }}" class="bg-white p-4 rounded-lg shadow">
            <div class="font-medium text-sm">{{ $product->name }}</div>
            <div class="text-indigo-600 mt-2 font-semibold">{{ number_format($product->effectivePrice()) }} PKR</div>
        </a>
    @empty
        <p class="text-gray-500">No products yet.</p>
    @endforelse
</div>
<div class="mt-6">{{ $products->links() }}</div>
@endsection
