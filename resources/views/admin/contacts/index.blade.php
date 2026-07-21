@extends('admin.layout')
@section('title', 'Contact Messages')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Customer Contact Messages</h1>
                <p class="text-xs text-gray-500 mt-0.5">Inquiries submitted by storefront visitors</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200">
            Total Messages: {{ $messages->total() }}
        </span>
    </div>

    {{-- Messages Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Sender Info</th>
                        <th class="px-6 py-3.5">Message Content</th>
                        <th class="px-6 py-3.5">Received Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-gray-50/50 transition-colors align-top">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $msg->name }}</div>
                                <div class="text-xs text-indigo-600 font-medium mt-0.5">✉️ {{ $msg->email }}</div>
                                @if ($msg->phone)
                                    <div class="text-xs text-emerald-600 font-medium mt-0.5">📱 {{ $msg->phone }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xl">
                                <p class="text-gray-800 leading-relaxed text-xs bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                    {{ $msg->message }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-gray-400 font-medium whitespace-nowrap">
                                {{ $msg->created_at->format('d M, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
