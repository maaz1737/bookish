@extends('admin.layout')
@section('title','New Product')
@section('content')
<h1 class="text-2xl font-bold mb-6">New Product</h1>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
    @include('admin.products._form')
</form>
@endsection
