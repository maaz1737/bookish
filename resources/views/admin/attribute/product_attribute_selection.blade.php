@extends('admin.layout')

@section('title', 'Product Attribute Selection')
@section('content')
    <div class="container mx-auto p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-bold">
                Select Attributes For {{ $product->name }}
            </h1>
        </div>

        <form action="{{ route('admin.products.attributes.store', $product->slug) }}" method="POST">
            @csrf

            <div class="grid gap-4">

                @foreach($attributes as $attribute)
                    <div class="border rounded-lg p-4">

                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="attribute_ids[]" value="{{ $attribute->id }}"
                                class="checkbox checkbox-primary">

                            <span class="font-semibold">
                                {{ $attribute->name }}
                            </span>
                        </label>

                        @if($attribute->values->count())
                            <div class="mt-3 ml-8 flex flex-wrap gap-2">

                                @foreach($attribute->values as $value)
                                    <span class="px-3 py-1 bg-gray-100 rounded">
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
@endsection