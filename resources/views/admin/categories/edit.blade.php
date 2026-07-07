@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Edit Category</h1>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
        class="bg-white p-6 rounded-xl shadow-md border border-gray-100 space-y-5">

        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category Name
            </label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Parent Category
            </label>

            <select name="parent_id"
                class="select2-single w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                <option value="">-- Root Category --</option>

                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach

            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description', $category->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category Image
            </label>

            @if ($category->image)
                <div class="mb-2">
                    <img src="{{ app()->environment('production')
                ? url('storage/' . $category->image)
                : asset('storage/' . $category->image) }}" class="w-20 h-20 object-cover rounded-lg border">
                </div>
            @endif

            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        <div class="flex items-center gap-3">
            <input id="showOnDashboard" type="checkbox" name="show_on_dashboard" value="1" {{ old('show_on_dashboard', $category->show_on_dashboard) ? 'checked' : '' }}
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

            <label for="showOnDashboard" class="text-sm font-medium text-gray-700">
                Show on Dashboard
            </label>
        </div>
        <div class="flex items-center gap-3">
            <input id="showOnMenu" type="checkbox" name="show_on_menu" value="0" {{ old('show_on_menu', $category->show_on_menu) ? 'checked' : '' }}
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

            <label for="showOnMenu" class="text-sm font-medium text-gray-700">
                Show on Main Menu
            </label>
        </div>
        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
                Update Category
            </button>
        </div>

    </form>

@endsection