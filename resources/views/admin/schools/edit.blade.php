@extends('admin.layout')
@section('title', 'Schools')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Schools</h1>
    <form method="POST" action="{{ route('admin.schools.update', $school->slug) }}"
        class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
        @csrf
        @method('put')
        <input name="name" value="{{ $school->name }}" placeholder="School name" required
            class="border rounded px-3 py-2 flex-1">
        <button class="bg-indigo-600 text-white px-4 rounded">Update</button>
    </form>
@endsection
