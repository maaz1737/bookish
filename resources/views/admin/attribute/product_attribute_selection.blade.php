@extends('admin.layout')

@section('title', 'Product Attribute Selection')
@section('content')
    @if ($attributes->isEmpty())

        <div class="container mx-auto p-6">

            <div class="max-w-lg mx-auto text-center bg-white shadow rounded-lg p-8">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />

                </svg>

                <h2 class="text-2xl font-bold mt-4">
                    No Attributes Found
                </h2>

                <p class="text-gray-600 mt-2">
                    You need to create product attributes before creating variants.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">

                    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary px-6">

                        <i class="fa-solid fa-layer-group mr-2"></i>
                        Create Product Attribute

                    </a>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline px-6">

                        <i class="fa-solid fa-box mr-2"></i>
                        Back to Products

                    </a>

                </div>

            </div>

        </div>
    @else
        <div class="container mx-auto p-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold">
                    Select Attributes For {{ $product->name }}
                </h1>

                <p class="text-gray-500 mt-1">
                    Choose the attributes that this product will use.
                </p>
            </div>

            <form action="{{ route('admin.products.attributes.store', $product->slug) }}" method="POST">
                @csrf

                <div class="grid gap-4">

                    @foreach ($attributes as $attribute)
                        <div class="border rounded-lg p-4">

                            <label class="flex items-center gap-3 cursor-pointer">

                                <input type="checkbox" name="attribute_ids[]" value="{{ $attribute->id }}"
                                    class="checkbox checkbox-primary">

                                <span class="font-semibold">
                                    {{ $attribute->name }}
                                </span>

                            </label>

                            @if ($attribute->values->isNotEmpty())
                                <div class="mt-3 ml-8 flex flex-wrap gap-2">

                                    @foreach ($attribute->values as $value)
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">
                                            {{ $value->value }}
                                        </span>
                                    @endforeach

                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>

                <div class="mt-6">

                    <button type="submit" class="btn btn-primary">
                        Next Step
                    </button>

                </div>

            </form>

        </div>

    @endif
@endsection
