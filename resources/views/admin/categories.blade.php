@extends('admin.layout')
@section('title','Categories')
@section('content')
<h1 class="text-2xl font-bold mb-6">Categories</h1>
<form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
    @csrf
    <input name="name" placeholder="Category name" required class="border rounded px-3 py-2 flex-1">
    <select name="type" class="border rounded px-3 py-2"><option value="book">book</option><option value="uniform">uniform</option><option value="accessory">accessory</option></select>
    <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
</form>
<div class="bg-white rounded-lg shadow divide-y">
@foreach ($categories as $c)
    <div class="flex items-center justify-between p-3 text-sm">
        <span>{{ $c->name }} <span class="text-gray-400">({{ $c->type }}, {{ $c->products_count }} products)</span></span>
        <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-500">Delete</button></form>
    </div>
@endforeach
</div>
@endsection
