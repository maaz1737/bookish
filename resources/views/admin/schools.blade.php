@extends('admin.layout')
@section('title', 'Schools')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Schools</h1>
    <form method="POST" action="{{ route('admin.schools.store') }}" class="bg-white p-4 rounded-lg shadow flex gap-2 mb-6">
        @csrf
        <input name="name" placeholder="School name" required class="border rounded px-3 py-2 flex-1">
        <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
    </form>
    <div class="bg-white rounded-lg shadow divide-y">
        @foreach ($schools as $s)
            <div class="flex items-center justify-between p-3 text-sm">
                <span>{{ $s->name }} <span class="text-gray-400">({{ $s->classes_count }} classes)</span></span>
                <div>
                    <a href="{{ route('admin.schools.edit', $s->slug) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.schools.destroy', $s) }}"
                        onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')<button class="text-red-500">Delete</button></form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
