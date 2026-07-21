@extends('admin.layout')
@section('title', 'Payment Verification')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" stroke="currentColor" stroke-width="1.8"/>
                    <line x1="1" y1="10" x2="23" y2="10" stroke="currentColor" stroke-width="1.8"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Payment Verification Queue</h1>
                <p class="text-xs text-gray-500 mt-0.5">Review and verify submitted payment proofs</p>
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
                        <th class="px-6 py-3.5">Total Amount</th>
                        <th class="px-6 py-3.5">Payment Source</th>
                        <th class="px-6 py-3.5">Submitted</th>
                        <th class="px-6 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($proofs as $proof)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-900 text-sm">
                                #{{ $proof->order->order_number }}
                            </td>
                            <td class="px-6 py-4 font-extrabold text-gray-900 text-sm">
                                {{ number_format($proof->order->total_amount) }} <span class="text-xs text-gray-400 font-normal">PKR</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                    {{ ucfirst($proof->source) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-medium">
                                {{ $proof->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.payments.show', $proof) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 px-3.5 py-1.5 rounded-lg transition border border-amber-200">
                                    Verify Proof
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                No pending payment proofs awaiting verification.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
