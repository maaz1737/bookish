@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">Schools</h1>
<div class="grid sm:grid-cols-3 gap-4">
    @foreach ($schools as $school)
        <a href="{{ route('schools.show', $school) }}" class="bg-white p-5 rounded-lg shadow">
            <div class="font-medium">{{ $school->name }}</div>
            <div class="text-sm text-gray-500">{{ $school->classes_count }} classes</div>
        </a>
    @endforeach
</div>
@endsection
