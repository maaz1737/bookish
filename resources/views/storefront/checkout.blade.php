@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">Checkout</h1>
<form method="POST" action="{{ route('checkout.place') }}" class="bg-white rounded-lg shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">Full Name</label>
        <input name="customer_name" required class="w-full border rounded px-3 py-2" value="{{ old('customer_name') }}">
        @error('customer_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Mobile Number</label>
        <input name="mobile" required class="w-full border rounded px-3 py-2" value="{{ old('mobile') }}">
        @error('mobile')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Shipping Address</label>
        <textarea name="address" required class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
        @error('address')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>
    <button class="w-full bg-indigo-600 text-white py-3 rounded font-medium">Place Order</button>
    <p class="text-xs text-gray-400 text-center">No account needed — guest checkout.</p>
</form>
@endsection
