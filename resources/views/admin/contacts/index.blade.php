@extends('admin.layout') {{-- Aapke admin layout ka jo bhi naam hai --}}

@section('title', 'Contact Messages')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-900">User Contact Messages</h1>
            <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                Total: {{ $messages->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm text-gray-600">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs border-b border-gray-200">
                        <th class="p-4">Name & Email</th>
                        <th class="p-4">Message</th>
                        <th class="p-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="p-4">
                                <div class="font-semibold text-gray-900">{{ $msg->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $msg->email }}</div>
                                @if ($msg->phone)
                                    <div class="text-xs text-green-600 mt-0.5">{{ $msg->phone }}</div>
                                @endif
                            </td>
                            {{-- Subject Column has been removed --}}
                            <td class="p-4 max-w-md truncate" title="{{ $msg->message }}">{{ $msg->message }}</td>
                            <td class="p-4 text-gray-400 text-xs">{{ $msg->created_at->format('d M, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Colspan updated to 3 because one column was removed --}}
                            <td colspan="3" class="p-8 text-center text-gray-400">
                                No messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    </div>
@endsection
