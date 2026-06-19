@extends('admin.layout')

@section('title', 'Add New Banner')

@section('content')
<div class="max-w-2xl bg-white rounded-xl shadow border border-gray-200 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add New Banner</h1>
        <p class="text-sm text-gray-500 mt-1">Upload a high-quality image slider banner for your home page.</p>
    </div>
    
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Banner Image <span class="text-red-500">*</span></label>
            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-800 border rounded p-1" required>
            <p class="text-xs text-gray-400 mt-1">Recommended dimension: 1200x400px (Aspect ratio 3:1). Formats: PNG, JPG, WEBP.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title (Optional)</label>
            <input type="text" name="title" placeholder="e.g., Back to School Sale" class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Redirect Link URL (Optional)</label>
            <input type="url" name="link" placeholder="e.g., https://yourdomain.com/schools/paf" class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
            <p class="text-xs text-gray-400 mt-1">When users click this banner, they will be redirected to this URL.</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="order" value="0" class="w-full border border-gray-300 rounded p-2 text-sm focus:outline-none focus:border-gray-900">
                <p class="text-xs text-gray-400 mt-1">Lower numbers display first (e.g., 0, 1, 2).</p>
            </div>
            
            <div class="flex items-center pt-6">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-gray-900 bg-gray-100 border-gray-300 rounded focus:ring-gray-900">
                    <span class="ml-2 text-sm font-semibold text-gray-700">Publish Immediately</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
            <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded font-medium hover:bg-gray-800 text-sm transition">
                Save Banner
            </button>
            <a href="{{ route('admin.banners.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-4 py-2.5 hover:bg-gray-50 rounded border transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection