@extends('admin.layout')
@section('title', 'Shipping Zones')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="1" y="3" width="15" height="13" rx="1" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M16 8h4l3 3v5h-7V8z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <circle cx="5.5" cy="18.5" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="18.5" cy="18.5" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Shipping Zones & Rates</h1>
                <p class="text-xs text-gray-500 mt-0.5">Configure delivery regions, cities, and shipping fee rules</p>
            </div>
        </div>
        <a href="{{ route('admin.shipping.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Zone
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Zone ID</th>
                        <th class="px-6 py-3.5">Zone Name</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($zones as $zone)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-gray-500">
                                #{{ $zone->id }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                                {{ $zone->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if($zone->status == 'active')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.shipping.show', $zone->id) }}" class="font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                        View Rates
                                    </a>
                                    <a href="{{ route('admin.shipping.edit', $zone->id) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.shipping.destroy', $zone->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this zone?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                No shipping zones found. Click "+ Add New Zone" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $zones->links() }}
    </div>
</div>
@endsection