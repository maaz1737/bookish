@extends('layouts.app')
@section('content')
{{-- JSON-LD product schema (no publisher exposed) --}}
<script type="application/ld+json">{!! json_encode($jsonLd) !!}</script>

<div class="bg-white rounded-lg shadow p-8 grid sm:grid-cols-2 gap-8">
    <div class="bg-gray-100 rounded h-72 flex items-center justify-center text-gray-400">Image</div>
    <div>
        <span class="text-xs uppercase tracking-wide text-gray-400">{{ $product->category->name }}</span>
        <h1 class="text-2xl font-bold mt-1">{{ $product->name }}</h1>

        @if ($product->size || $product->gender)
            <p class="text-sm text-gray-500 mt-2">
                @if($product->size) Size: {{ $product->size }} @endif
                @if($product->gender) · {{ ucfirst($product->gender) }} @endif
            </p>
        @endif

        <div class="text-2xl font-bold text-indigo-600 mt-4">{{ number_format($product->effectivePrice()) }} PKR</div>
        <p class="text-gray-600 mt-4">{{ $product->description }}</p>

        <form method="POST" action="{{ route('cart.addProduct', $product) }}" class="mt-6 flex gap-3">
            @csrf
            <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-6 py-2 rounded font-medium"
                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                {{ $product->stock > 0 ? 'Add to cart' : 'Out of stock' }}
            </button>
        </form>
    </div>
</div>
@endsection
