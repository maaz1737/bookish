@extends('admin.layout')
@section('title', 'Verify Payment')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Verify Payment — {{ $proof->order->order_number }}</h1>
    <div class="grid sm:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-semibold mb-2">Uploaded screenshot</h2>
            <img src="{{ asset(
                app()->environment('local')
                    ? 'storage/' . $proof->screenshot_path
                    : 'storage/app/public/' . $proof->screenshot_path,
            ) }}"
                class="w-full rounded border">
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold mb-3">Expected payment</h2>
            <p class="text-sm">Order: <strong>{{ $proof->order->order_number }}</strong></p>
            <p class="text-sm">Amount: <strong>{{ number_format($proof->order->total_amount) }} PKR</strong></p>
            <p class="text-sm mb-4">Customer: {{ $proof->order->customer_name }} ({{ $proof->order->mobile }})</p>

            <form method="POST" action="{{ route('admin.payments.approve', $proof) }}" class="space-y-2">
                @csrf
                <input name="note" placeholder="Optional note" class="w-full border rounded px-3 py-2 text-sm">
                <button class="w-full bg-green-600 text-white py-2 rounded">Approve & Mark Paid</button>
            </form>
            <form method="POST" action="{{ route('admin.payments.reject', $proof) }}" class="mt-2">
                @csrf <button class="w-full bg-red-100 text-red-700 py-2 rounded">Reject</button>
            </form>
        </div>
    </div>
@endsection
