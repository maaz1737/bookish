@extends('admin.layout') {{-- Agar aapke layout file ka naam layouts.admin hai to --}}

@section('title', 'attributes')

@section('content')
    <div class="max-w-6xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Attributes</h2>

            <a href="{{ route('admin.attributes.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Create Attribute
            </a>
        </div>

        {{-- Attributes List --}}
        <div class="space-y-4">

            @forelse($attributes as $attribute)
                <div class="border rounded-lg p-4 bg-white shadow-sm">

                    {{-- Header row --}}
                    <div class="flex justify-between items-center">

                        <h3 class="text-lg font-semibold">
                            {{ $attribute->name }}
                        </h3>

                        <div class="flex gap-2">

                            {{-- Edit --}}
                            <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </div>

                    {{-- Attribute Values --}}
                    <div class="mt-3 flex flex-wrap gap-2">

                        @forelse($attribute->values as $value)
                            <span class="px-3 py-1 bg-gray-100 border rounded-full text-sm">
                                {{ $value->value }}
                            </span>
                        @empty
                            <span class="text-gray-400 text-sm">
                                No value added
                            </span>
                        @endforelse

                    </div>

                </div>
            @empty
                <p class="text-gray-500">No attributes found.</p>
            @endforelse

        </div>

    </div>
@endsection
