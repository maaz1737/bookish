@extends('admin.layout')

@section('content')
    <div class="p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Shipping Zones</h1>

            <a href="{{ route('admin.shipping.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Add Zone
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        {{-- <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search zones..."
                class="w-full md:w-1/3 border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
        </form> --}}

        {{-- Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Zone Name</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($zones as $zone)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $zone->id }}</td>

                            <td class="p-3 font-medium text-gray-800">
                                {{ $zone->name }}
                            </td>

                            <td class="p-3">
                                @if($zone->status == 'active')
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

                                <a href="{{ route('admin.shipping.show', $zone->id) }}" class="text-blue-600 hover:underline">
                                    View
                                </a>

                                <a href="{{ route('admin.shipping.edit', $zone->id) }}" class="text-yellow-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{route('admin.shipping.destroy', $zone->id)}}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this zone?')">
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
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No shipping zones found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $zones->links() }}
        </div>

    </div>
@endsection