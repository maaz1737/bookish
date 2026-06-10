@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">Your Cart</h1>
@if (empty($cart['items']))
    <p class="text-gray-500">Your cart is empty. <a href="{{ route('schools.index') }}" class="text-indigo-600">Browse schools</a>.</p>
@else
<div class="bg-white rounded-lg shadow divide-y">
    @foreach ($cart['items'] as $key => $item)
        <div class="flex items-center justify-between p-4">
            <div>{{ $item['name'] }} <span class="text-gray-400">×{{ $item['quantity'] }}</span></div>
            <div class="flex items-center gap-4">
                <span class="font-medium">{{ number_format($item['price'] * $item['quantity']) }} PKR</span>
                <form method="POST" action="{{ route('cart.remove', $key) }}">@csrf @method('DELETE')
                    <button class="text-red-500 text-sm">Remove</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
<div class="flex items-center justify-between mt-6">
    <div class="text-xl font-bold">Total: {{ number_format($cart['total']) }} PKR</div>
    <a href="{{ route('checkout.show') }}" class="bg-indigo-600 text-white px-6 py-3 rounded font-medium">Checkout</a>
</div>
@endif
@endsection
