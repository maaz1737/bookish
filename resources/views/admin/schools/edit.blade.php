@extends('admin.layout')
@section('title', 'Edit School')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit School</h1>
    <form method="POST" action="{{ route('admin.schools.update', $school->slug) }}" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow max-w-lg">
        @csrf
        @method('put')
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">School Name</label>
            <input name="name" value="{{ $school->name }}" placeholder="School name" required
                class="border rounded px-3 py-2 w-full">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo Emblem</label>
            @if ($school->logo)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }} current logo" class="w-16 h-16 object-contain rounded border p-1 bg-slate-50">
                    <span class="text-xs text-gray-500">Current Logo</span>
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="border rounded px-3 py-2 w-full text-sm">
            <p class="text-xs text-gray-400 mt-1">Leave blank to keep the current logo.</p>
        </div>

        <div class="flex gap-2">
            <button class="bg-indigo-600 text-white px-5 py-2.5 rounded font-semibold text-sm">Update</button>
            <a href="{{ route('admin.schools.index') }}" class="border border-gray-300 text-gray-700 px-5 py-2.5 rounded font-semibold text-sm">Cancel</a>
        </div>
    </form>
@endsection
