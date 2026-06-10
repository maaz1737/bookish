@extends('admin.layout')
@section('title','Classes')
@section('content')
<h1 class="text-2xl font-bold mb-6">Classes</h1>
<form method="POST" action="{{ route('admin.classes.store') }}" class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
    @csrf
    <select name="school_id" required class="border rounded px-3 py-2">@foreach ($schools as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select>
    <input name="name" placeholder="Class name e.g. Class 6" required class="border rounded px-3 py-2 flex-1">
    <input name="sort_order" type="number" placeholder="Order" class="border rounded px-3 py-2 w-24">
    <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
</form>
<div class="bg-white rounded-lg shadow divide-y">
@foreach ($classes as $cl)
    <div class="flex items-center justify-between p-3 text-sm">
        <span>{{ $cl->school->name }} — {{ $cl->name }}</span>
        <form method="POST" action="{{ route('admin.classes.destroy', $cl) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-500">Delete</button></form>
    </div>
@endforeach
</div>
@endsection
