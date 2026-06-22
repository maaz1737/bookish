@extends('admin.layout')

@section('title', 'Edit Attribute')

@section('content')
    <div class="max-w-4xl mx-auto p-6">

        {{-- Attribute Edit Card --}}
        <div class="bg-white p-6 rounded-lg shadow">

            <div class="mb-6">
                <h2 class="text-2xl font-bold">Edit Attribute</h2>
                <p class="text-gray-500 text-sm">
                    Update attribute information.
                </p>
            </div>

            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" class="space-y-5">

                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Attribute Name
                    </label>

                    <input type="text" name="name" value="{{ old('name', $attribute->name) }}"
                        placeholder="e.g. Color, Size, Material"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-between items-center">

                    <a href="{{ route('admin.attributes.index') }}" class="text-gray-600 hover:underline">
                        ← Back
                    </a>

                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                        Update Attribute
                    </button>

                </div>

            </form>

        </div>

        {{-- Attribute Values --}}
        <div class="bg-white p-6 rounded-lg shadow mt-6">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold">
                        Attribute Values
                    </h3>

                    <p class="text-sm text-gray-500">
                        Manage values for {{ $attribute->name }}
                    </p>
                </div>

                <a href="{{ route('admin.attributes.value.create', ['attribute' => $attribute->id]) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    + Add Value
                </a>
            </div>

            @forelse($attribute->values as $value)
                <div class="flex justify-between items-center border-b py-4">

                    <div>
                        <span class="font-medium text-gray-800">
                            {{ $value->value }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">

                        {{-- Edit Value --}}
                        <a href="{{ route('admin.attributes.value.edit', [
                            'attribute' => $attribute->id,
                            'value' => $value->id,
                        ]) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        {{-- Delete Value --}}
                        <form action="{{ route('admin.attributes.value.destroy', ['value' => $value->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this value?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="text-center py-10 text-gray-500">
                    No values found for this attribute.
                </div>
            @endforelse

        </div>

    </div>
@endsection
