@extends('admin.layout') {{-- Agar aapke layout file ka naam layouts.admin hai to --}}

@section('title', 'attribute values')

@section('content')
    <div class="max-w-3xl mx-auto p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold">
                Add Values for: {{ $attribute->name }}
            </h2>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.attributes.value.store', $attribute->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow space-y-4">
            @csrf

            {{-- Dynamic Inputs Container --}}
            <div id="values-wrapper" class="space-y-3">

                <div class="flex gap-2 value-row">
                    <input type="text" name="values[]" placeholder="Enter value (e.g. Red, Blue)"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

                    <button type="button" class="remove-btn bg-red-500 text-white px-3 rounded hover:bg-red-600">
                        ✕
                    </button>
                </div>

            </div>

            {{-- Add Button --}}
            <button type="button" id="add-value" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                + Add More
            </button>

            {{-- Submit --}}
            <div class="flex justify-between items-center pt-4">

                <a href="{{ route('admin.attributes.index') }}" class="text-gray-600 hover:underline">
                    ← Back
                </a>

                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                    Save Values
                </button>

            </div>
        </form>

    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const wrapper = document.getElementById('values-wrapper');
            const addBtn = document.getElementById('add-value');

            // Add new input row
            addBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.classList.add('flex', 'gap-2', 'value-row');

                row.innerHTML = `
            <input type="text"
                   name="values[]"
                   placeholder="Enter value"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">

            <button type="button"
                    class="remove-btn bg-red-500 text-white px-3 rounded hover:bg-red-600">
                ✕
            </button>
        `;

                wrapper.appendChild(row);
            });

            // Remove input row
            wrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-btn')) {
                    const rows = document.querySelectorAll('.value-row');

                    // prevent removing last input
                    if (rows.length > 1) {
                        e.target.parentElement.remove();
                    }
                }
            });

        });
    </script>
@endsection
