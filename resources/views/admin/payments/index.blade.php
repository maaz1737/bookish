@extends('admin.layout')
@section('title','Payment Verification')
@section('content')
<h1 class="text-2xl font-bold mb-6">Payment Verification Queue</h1>
<div class="bg-white rounded-lg shadow overflow-x-auto">
<table class="w-full text-sm"><thead class="bg-gray-50 text-left"><tr>
<th class="p-3">Order #</th><th class="p-3">Amount</th><th class="p-3">Source</th><th class="p-3">Submitted</th><th class="p-3"></th></tr></thead>
<tbody class="divide-y">
@forelse ($proofs as $proof)
<tr>
    <td class="p-3 font-mono">{{ $proof->order->order_number }}</td>
    <td class="p-3">{{ number_format($proof->order->total_amount) }} PKR</td>
    <td class="p-3">{{ ucfirst($proof->source) }}</td>
    <td class="p-3">{{ $proof->created_at->diffForHumans() }}</td>
    <td class="p-3"><a href="{{ route('admin.payments.show', $proof) }}" class="text-indigo-600">Verify</a></td>
</tr>
@empty
<tr><td colspan="5" class="p-6 text-center text-gray-400">No pending proofs.</td></tr>
@endforelse
</tbody></table></div>
@endsection
