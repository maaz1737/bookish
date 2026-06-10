@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-2">Complete Your Payment</h1>
    <p class="text-gray-500 mb-6">Order <strong>{{ $order->order_number }}</strong> — {{ number_format($order->total_amount) }} PKR</p>

    {{-- Active timeline (Section 8) --}}
    <ol class="flex justify-between text-xs mb-8">
        @foreach (['Order placed','Transfer funds','Upload proof','Verified'] as $i => $step)
            <li class="flex-1 text-center {{ $order->payment_status==='paid' || $i < 2 ? 'text-indigo-600 font-semibold' : 'text-gray-400' }}">
                <div class="w-3 h-3 mx-auto rounded-full mb-1 {{ $i < 2 ? 'bg-indigo-600' : 'bg-gray-300' }}"></div>
                {{ $step }}
            </li>
        @endforeach
    </ol>

    <div class="bg-white rounded-lg shadow p-6 space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-gray-500">Bank</span><span>{{ $bank['bank_name'] }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Account Title</span><span>{{ $bank['account_title'] }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">IBAN</span><span>{{ $bank['iban'] }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Account #</span><span>{{ $bank['account_no'] }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Raast ID</span><span>{{ $bank['raast_id'] }}</span></div>
    </div>

    <form method="POST" action="{{ route('checkout.proof', $order->order_number) }}" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 mt-6">
        @csrf
        <label class="block text-sm font-medium mb-2">Upload your payment receipt screenshot</label>
        <input type="file" name="screenshot" accept="image/*" required class="w-full text-sm">
        @error('screenshot')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        <button class="mt-4 w-full bg-indigo-600 text-white py-3 rounded font-medium">Submit Payment Proof</button>
    </form>
    <p class="text-center text-sm text-gray-400 mt-4">
        Status: <strong>{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}</strong> ·
        <a href="{{ route('order.track', $order->order_number) }}" class="text-indigo-600">Track order</a>
    </p>
</div>
@endsection
