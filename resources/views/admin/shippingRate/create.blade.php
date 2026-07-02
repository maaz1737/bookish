@extends('admin.layout')

@section('content')
    <div class="p-6 max-w-2xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create Shipping Rate</h1>

            <a href="{{ route('admin.shipping.show', $zone->id) }}" class="text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.rates.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-5">
            @csrf

            {{-- Hidden Zone --}}
            <input type="hidden" name="shipping_zone_id" value="{{ $zone->id }}">

            {{-- Rate Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Rate Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Standard, Express, Free Shipping"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- Price --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Price (Rs)</label>
                <input type="number" name="price" value="{{ old('price', 0) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Estimated Days</label>
                <input type="number" name="estimated_days" value="{{ old('estimated_days', 0) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="e.g. 5000 for free shipping">
            </div>
            {{-- Min Order Amount --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Minimum Order Amount (optional)</label>
                <input type="number" name="min_order_amount" value="{{ old('min_order_amount', 0) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="e.g. 5000 for free shipping">
            </div>

            {{-- Free Shipping Toggle --}}
            <div class="space-y-2">
                <label class="block text-gray-700 font-medium">
                    Free Shipping Rule (optional)
                </label>

                <input type="number" name="free_shipping_min_order" value="{{ old('free_shipping_min_order') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                    placeholder="e.g. 5000 (leave empty if not applicable)">

                <p class="text-sm text-gray-500">
                    Free shipping will be applied when order total is equal or greater than this amount.
                </p>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Status</label>

                <div class="flex space-x-6">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="status" value="active" checked>
                        <span>Active</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="radio" name="status" value="inactive">
                        <span>Inactive</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Save Rate
            </button>

        </form>

    </div>
@endsection