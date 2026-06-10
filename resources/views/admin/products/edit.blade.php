@extends('admin.layout')
@section('title','Edit Product')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Product</h1>
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
    @method('PUT')
    @include('admin.products._form')
</form>
@endsection
