@extends('admin.layout')
@section('title', 'Categories')
@section('content')
    <div class="flex items-center justify-between px-4 mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>

        <a href="{{ route('admin.categories.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg transition">
            Add New Category
        </a>
    </div>
    <div class="bg-white rounded-xl shadow divide-y">

        @foreach ($categories as $c)
            <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition">

                <!-- Left Side -->
                <div class="flex items-center gap-4">

                    <!-- Image -->
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                        @if ($c->image)
                            <img src="{{ app()->environment('production') ? url('storage/' . $c->image) : asset('storage/' . $c->image) }}"
                                class="w-full h-full object-cover" alt="{{ $c->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                No Img
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-800">
                                {{ $c->name }}
                            </h3>

                            <!-- Type badge -->
                            <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                {{ ucfirst($c->type) }}
                            </span>

                            <!-- Dashboard visibility -->
                            @if ($c->show_on_dashboard)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">
                                    Visible
                                </span>
                            @else
                                <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">
                                    Hidden
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-gray-500 mt-1">
                            {{ Str::limit($c->description, 60) }}
                        </p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4 text-sm">

                    <!-- Product Count -->
                    <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                        {{ $c->products_count }} products
                    </span>

                    <!-- Actions -->
                    <a href="{{ route('admin.categories.edit', $c) }}" class="text-indigo-600 hover:underline">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('admin.categories.destroy', $c) }}"
                        onsubmit="return confirm('Delete?')">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-500 hover:underline">
                            Delete
                        </button>
                    </form>

                </div>

            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
