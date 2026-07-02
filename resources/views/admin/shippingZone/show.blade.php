@extends('admin.layout')

@section('content')
    <div class="p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Shipping Zone: {{ $zone->name }}
                </h1>

                <p class="text-sm text-gray-500">
                    Manage all shipping rates for this zone
                </p>
            </div>

            <div class="space-x-2">
                <a href="{{ route('admin.shipping.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                    Back
                </a>

                <a href="{{ route('admin.rates.create', $zone->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    + Add Rate
                </a>
            </div>
        </div>

        {{-- Zone Info Card --}}
        <div class="bg-white shadow rounded-lg p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <p class="text-gray-500 text-sm">Zone Name</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $zone->name }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Status</p>

                    @if($zone->status)
                        <span class="inline-block mt-1 px-3 py-1 text-sm bg-green-100 text-green-700 rounded">
                            Active
                        </span>
                    @else
                        <span class="inline-block mt-1 px-3 py-1 text-sm bg-red-100 text-red-700 rounded">
                            Inactive
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Total Rates</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $zone->rates->count() }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Rates Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">

            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-700">
                    Shipping Rates
                </h2>
            </div>

            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">Method</th>
                        <th class="p-3">Price</th>
                        <th class="p-3">Free Above</th>
                        <th class="p-3">Delivery Days</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($zone->rates as $rate)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3 font-medium text-gray-800">
                                {{ $rate->name }}
                            </td>

                            <td class="p-3">
                                Rs. {{ $rate->price }}
                            </td>

                            <td class="p-3">
                                Rs. {{ $rate->free_shipping ?? 'N/A' }}
                            </td>

                            <td class="p-3">
                                {{ $rate->estimated_days }}
                            </td>

                            <td class="p-3">
                                @if($rate->status)
                                    <span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 text-right space-x-2">

                                <a href="" class="text-yellow-600 hover:underline">
                                    Edit
                                </a>

                                <form action="" method="POST" class="inline-block"
                                    onsubmit="return confirm('Delete this shipping rate?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                No shipping rates found for this zone.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection