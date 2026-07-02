@extends('admin.layout')

@section('title', 'Edit Banner')

@section('content')
    <div class="max-w-2xl bg-white rounded-xl shadow border border-gray-200 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Banner</h1>
            <p class="text-sm text-gray-500 mt-1">Update banner information or change the active slider image.</p>
        </div>

        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Banner Image</label>
                <div class="p-2 border rounded-lg bg-gray-50 mb-3">
                    <img src="{{ app()->environment('production') ? asset('storage/' . $banner->image_path) : asset('storage/' . $banner->image_path) }}"
                        class="w-full h-48 object-cover rounded">
                </div>

                <label class="block text-sm font-semibold text-gray-700 mb-1">Upload New Image (Leave empty to keep
                    current)</label>
                <input type="file" name="image"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-800 border rounded p-1">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Internal Title</label>
                    <input type="text" name="title" value="{{ $banner->title }}"
                        class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Top Tagline</label>
                    <input type="text" name="top_tagline" value="{{ $banner->top_tagline }}"
                        class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Main Headline</label>
                <input type="text" name="main_headline" value="{{ $banner->main_headline }}"
                    class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Subheadline</label>
                <textarea name="subheadline" rows="2"
                    class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">{{ $banner->subheadline }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Redirect Link URL (Optional)</label>
                <input type="url" name="link" value="{{ $banner->link }}"
                    class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="order" value="{{ $banner->order }}"
                        class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
                </div>

                <div class="flex items-center pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}
                            class="w-4 h-4 text-gray-900 bg-gray-100 border-gray-300 rounded focus:ring-gray-900">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Active / Visible</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
                <button type="submit"
                    class="bg-gray-900 text-white px-5 py-2.5 rounded font-medium hover:bg-gray-800 text-sm transition">
                    Update Banner
                </button>
                <a href="{{ route('admin.banners.index') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 px-4 py-2.5 hover:bg-gray-50 rounded border transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection