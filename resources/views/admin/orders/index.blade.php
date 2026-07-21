@extends('admin.layout')
@section('title', 'Orders')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Customer Orders</h1>
                <p class="text-xs text-gray-500 mt-0.5">Track and manage store purchases and fulfillment</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Order Number</th>
                        <th class="px-6 py-3.5">Customer Information</th>
                        <th class="px-6 py-3.5">Total Amount</th>
                        <th class="px-6 py-3.5">Payment Status</th>
                        <th class="px-6 py-3.5">Order Status</th>
                        <th class="px-6 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($orders as $o)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-900 text-sm">
                                #{{ $o->order_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $o->customer_name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5 font-medium">📱 {{ $o->mobile }}</div>
                            </td>
                            <td class="px-6 py-4 font-extrabold text-gray-900 text-sm">
                                {{ number_format($o->total_amount) }} <span class="text-xs text-gray-400 font-normal">PKR</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                    @if($o->payment_status == 'verified' || $o->payment_status == 'paid') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($o->payment_status == 'proof_submitted') bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @else bg-amber-50 text-amber-700 border border-amber-200 @endif">
                                    {{ str_replace('_',' ',$o->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                    @if($o->order_status == 'completed') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($o->order_status == 'cancelled') bg-rose-50 text-rose-700 border border-rose-200
                                    @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                    {{ str_replace('_',' ',$o->order_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $o) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
