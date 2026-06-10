@extends('layouts.app')
@section('content')
<section class="bg-indigo-600 text-white rounded-xl p-10 mb-10">
    <h1 class="text-3xl font-bold mb-2">Everything for the new school year</h1>
    <p class="opacity-90">Class-wise book bundles, uniforms & accessories — delivered across Pakistan.</p>
    <a href="{{ route('schools.index') }}" class="inline-block mt-4 bg-white text-indigo-600 px-5 py-2 rounded font-medium">Shop by School</a>
</section>

<h2 class="text-xl font-semibold mb-4">Browse Schools</h2>
<div class="grid sm:grid-cols-3 gap-4 mb-10">
    @foreach ($schools as $school)
        <a href="{{ route('schools.show', $school) }}" class="bg-white p-5 rounded-lg shadow hover:shadow-md">
            <div class="font-medium">{{ $school->name }}</div>
            <div class="text-sm text-indigo-600 mt-1">View class bundles →</div>
        </a>
    @endforeach
</div>

<h2 class="text-xl font-semibold mb-4">Featured Products</h2>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    @foreach ($featured as $product)
        <a href="{{ route('product.show', $product) }}" class="bg-white p-4 rounded-lg shadow">
            <div class="font-medium text-sm">{{ $product->name }}</div>
            <div class="text-indigo-600 mt-2 font-semibold">{{ number_format($product->effectivePrice()) }} PKR</div>
        </a>
    @endforeach
</div>
@endsection
