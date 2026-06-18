@extends('admin.layout')
@section('title', 'Classes')
@section('content')
    <h1 class="text-2xl font-bold mb-6">
        Classes</h1>
    <form method="POST" action="{{ route('admin.classes.update', $class->id) }}"
        class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
        @csrf
        @method('put')
        <select name="school_id" required class="border rounded px-3 py-2">
            @foreach ($schools as $s)
                <option value="{{ $s->id }}" {{ $class->school_id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
        <input name="name" value="{{ $class->name }}" placeholder="Class name e.g. Class 6" required
            class="border rounded px-3 py-2 flex-1">
        <input value="{{ $class->sort_order }}" name="sort_order" type="number" placeholder="Order"
            class="border rounded px-3 py-2 w-24">
        <button class="bg-indigo-600 text-white px-4 rounded">Update</button>
    </form>
@endsection
