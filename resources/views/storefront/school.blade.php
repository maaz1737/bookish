@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-2">{{ $school->name }}</h1>
<p class="text-gray-500 mb-6">Select a class to view its book bundle.</p>
<div class="grid sm:grid-cols-3 gap-4">
    @foreach ($school->classes as $class)
        <a href="{{ route('bundle.show', [$school, $class->slug]) }}" class="bg-white p-5 rounded-lg shadow">
            <div class="font-medium">{{ $class->name }}</div>
            <div class="text-sm text-indigo-600 mt-1">View bundle →</div>
        </a>
    @endforeach
</div>
@endsection
