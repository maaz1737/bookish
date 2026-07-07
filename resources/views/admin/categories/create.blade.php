@extends('admin.layout')
@section('title', 'Categories')
@section('content')

    <h1 class="text-2xl font-bold mb-6">Categories</h1>
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
        class="bg-white p-6 rounded-xl shadow-md border border-gray-100 space-y-5">
        @csrf
        <h2 class="text-xl font-semibold text-gray-800">
            Add New Category
        </h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category Name
            </label>
            <input type="text" name="name" placeholder="Enter category name" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Parent Category
            </label>

            <select name="parent_id"
                class="select2-single w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                <option value="">-- Root Category --</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" class="px-2">{{ $category->name }}</option>
                @endforeach

            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea name="description" rows="4" placeholder="Write a short description..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category Image
            </label>
            <input type="file" name="image" accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 file:bg-indigo-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-md file:cursor-pointer">
        </div>
        <div class="flex items-center gap-3">
            <input id="showOnDashboard" type="checkbox" name="show_on_dashboard" value="1" checked
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

            <label for="showOnDashboard" class="text-sm font-medium text-gray-700">
                Show on Dashboard
            </label>
        </div>
        <div class="flex items-center gap-3">
            <input id="showOnMenu" type="checkbox" name="show_on_menu" value="0"
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

            <label for="showOnMenu" class="text-sm font-medium text-gray-700">
                Show on Main Menu
            </label>
        </div>
        <div class="flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition">
                Add Category
            </button>
        </div>

    </form>


@endsection