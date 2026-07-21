@extends('admin.layout')
@section('title', 'Attributes')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5a1.99 1.99 0 0 1 1.414.586l7 7a2 2 0 0 1 0 2.828l-7 7a2 2 0 0 1-2.828 0l-7-7A1.994 1.994 0 0 1 3 12V7a4 4 0 0 1 4-4z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Product Attributes</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage custom attributes (e.g., Cover Type, Language, Edition)</p>
            </div>
        </div>
        <a href="{{ route('admin.attributes.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Create Attribute
        </a>
    </div>

    {{-- Attributes List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($attributes as $attribute)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        {{ $attribute->name }}
                    </h3>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs transition">
                            Edit
                        </a>

                        <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attribute?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Attribute Values Pill badges --}}
                <div class="mt-4">
                    <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Available Values</div>
                    <div class="flex flex-wrap gap-2">
                        @forelse($attribute->values as $value)
                            <span class="inline-flex items-center px-3 py-1 bg-purple-50 border border-purple-200 text-purple-700 text-xs font-semibold rounded-full shadow-xs">
                                {{ $value->value }}
                            </span>
                        @empty
                            <span class="text-xs text-gray-400 font-medium italic">No values configured yet.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 bg-white rounded-2xl p-10 text-center text-gray-400 border border-gray-100 shadow-sm">
                No attributes found. Click "+ Create Attribute" to start!
            </div>
        @endforelse
    </div>
</div>
@endsection
