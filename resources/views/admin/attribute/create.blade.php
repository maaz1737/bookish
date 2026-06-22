@extends('admin.layout') {{-- Agar aapke layout file ka naam layouts.admin hai to --}}

@section('title', 'attributes create')

@section('content')
    <div class="max-w-2xl mx-auto p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Create Attribute</h2>
            <p class="text-gray-500 text-sm">Add a new attribute like Color, Size, Material, etc.</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.attributes.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-5">
            @csrf

            {{-- Attribute Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Attribute Name
                </label>

                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Color, Size, Material"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-between items-center">

                <a href="{{ route('admin.attributes.index') }}" class="text-gray-600 hover:underline">
                    ← Back
                </a>

                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                    Save Attribute
                </button>

            </div>
        </form>

    </div>
@endsection
