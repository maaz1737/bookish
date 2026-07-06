@extends('admin.layout')

@section('content')
    <div class="p-6 max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Edit Shipping Zone</h1>

            <a href="" class="text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.shipping.update', $zone->id) }}" method="POST"
            class="bg-white shadow rounded-lg p-6 space-y-5">

            @csrf
            @method('PUT')

            {{-- Zone Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">
                    Zone Name
                </label>

                <input type="text" name="name" value="{{ old('name', $zone->name) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Status
                </label>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="status" value="active" {{ old('status', $zone->status) == 'active' ? 'checked' : '' }}>
                        <span>Active</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="radio" name="status" value="inactive" {{ old('status', $zone->status) == 'inactive' ? 'checked' : '' }}>
                        <span>Inactive</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-4 flex space-x-3">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                    Update Zone
                </button>

                <a href="{{ route('admin.shipping.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
                    Cancel
                </a>
            </div>

        </form>

    </div>
@endsection