@extends('admin.layout')
@section('title', 'Categories')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Categories</h1>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
        class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
        @csrf
        @method('put')
        <input value="{{ $category->name }}" name="name" placeholder="Category name" required
            class="border rounded px-3 py-2 flex-1">
        <select name="type" class="border rounded px-3 py-2">
            <option value="book" {{ old('type', $category->type) == 'book' ? 'selected' : '' }}>book</option>
            <option value="uniform" {{ old('type', $category->type) == 'uniform' ? 'selected' : '' }}>uniform</option>
            <option value="accessory" {{ old('type', $category->type) == 'accessory' ? 'selected' : '' }}>accessory</option>
        </select>
        <button class="bg-indigo-600 text-white px-4 rounded">Update</button>
    </form>

@endsection
