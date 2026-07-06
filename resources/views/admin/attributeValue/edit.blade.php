@extends('admin.layout')

@section('title', 'Edit Attribute Value')

@section('content')
    <div class="max-w-2xl mx-auto p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Edit Attribute Value</h2>
            <p class="text-gray-500 text-sm">
                Update value for "{{ $value->attribute->name }}"
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.attributes.value.update', ['value' => $value->id]) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow space-y-5">

            @csrf
            @method('PUT')

            {{-- Attribute --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Attribute
                </label>

                <input type="text" value="{{ $value->attribute->name }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
            </div>

            {{-- Value --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Value
                </label>

                <input type="text" name="value" value="{{ old('value', $value->value) }}"
                    placeholder="e.g. Red, Blue, Large"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                @error('value')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-between items-center">

                <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="text-gray-600 hover:underline">
                    ← Back
                </a>

                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                    Update Value
                </button>

            </div>

        </form>

    </div>
@endsection
