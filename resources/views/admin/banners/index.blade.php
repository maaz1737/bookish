@extends('admin.layout')
@section('title', 'Manage Banners')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                    <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Home Page Banners</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage storefront slider banners and marketing promotional links</p>
            </div>
        </div>
        <a href="{{ route('admin.banners.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Banner
        </a>
    </div>

    {{-- Banners Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Banner Preview</th>
                        <th class="px-6 py-3.5">Title & Headlines</th>
                        <th class="px-6 py-3.5">Sort Order</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-gray-50/50 transition-colors align-top">
                            <td class="px-6 py-4">
                                <div class="w-40 h-24 rounded-xl overflow-hidden border border-gray-200 shadow-xs bg-gray-50">
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="Banner Preview">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-gray-900 text-sm">{{ $banner->title ?? 'Untitled Banner' }}</div>
                                <div class="space-y-1 border-l-2 border-indigo-100 pl-2.5 mt-2 text-xs text-gray-600">
                                    @if($banner->top_tagline) <div><span class="font-bold text-gray-400 uppercase text-[10px]">Tagline:</span> {{ $banner->top_tagline }}</div> @endif
                                    @if($banner->main_headline) <div><span class="font-bold text-gray-400 uppercase text-[10px]">Headline:</span> {{ $banner->main_headline }}</div> @endif
                                    @if($banner->subheadline) <div class="truncate max-w-md"><span class="font-bold text-gray-400 uppercase text-[10px]">Sub:</span> {{ $banner->subheadline }}</div> @endif
                                </div>

                                @if ($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank" class="text-xs text-indigo-600 hover:underline inline-flex items-center gap-1 mt-2">
                                        🔗 {{ $banner->link }}
                                    </a>
                                @else
                                    <span class="text-[11px] text-gray-400 block mt-2">No Redirect Link</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-700">
                                {{ $banner->order }}
                            </td>
                            <td class="px-6 py-4">
                                @if($banner->is_active)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700 border border-gray-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?')">
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
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                No banners configured. Click "+ Add New Banner" to get started!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection