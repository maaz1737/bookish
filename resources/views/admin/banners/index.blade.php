@extends('admin.layout') {{-- Agar aapke layout file ka naam layouts.admin hai to --}}

@section('title', 'Manage Banners')

@section('content')
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Home Page Banners</h1>
                <p class="text-sm text-gray-500 mt-1">Manage the hero section image slider for your storefront.</p>
            </div>
            <a href="{{ route('admin.banners.create') }}"
                class="bg-gray-900 text-white px-4 py-2 rounded font-medium hover:bg-gray-800 text-sm transition">
                + Add New Banner
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Preview</th>
                        <th class="px-6 py-3 text-left">Title / Info</th>
                        <th class="px-6 py-3 text-left">Sort Order</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ str_starts_with($banner->image_path, 'http')
                                    ? $banner->image_path
                                    : (app()->environment('production')
                                        ? asset('storage/app/public/' . $banner->image_path)
                                        : asset('storage/' . $banner->image_path)) }}"
                                    class="w-40 h-20 object-cover rounded border bg-gray-50">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $banner->title ?? 'Untitled Banner' }}</div>
                                @if ($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank"
                                        class="text-xs text-blue-600 hover:underline block mt-1 truncate max-w-xs">
                                        🔗 {{ $banner->link }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 block mt-1">No Redirect Link</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-600">
                                {{ $banner->order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.banners.edit', $banner) }}"
                                        class="text-gray-900 hover:text-gray-700 bg-gray-100 px-3 py-1 rounded border hover:bg-gray-200 transition text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded border border-red-200 hover:bg-red-100 transition text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                No banners found. Click "+ Add New Banner" to get started!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
