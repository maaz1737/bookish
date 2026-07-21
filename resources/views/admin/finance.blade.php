@extends('admin.layout')
@section('title', 'Finance')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <line x1="12" y1="1" x2="12" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Financial Overview</h1>
                <p class="text-xs text-gray-500 mt-0.5">Track store revenue analytics and payment ratios</p>
            </div>
        </div>
        <a href="{{ route('admin.finance.export') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export Financial CSV
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            'Today' => ['val' => $daily, 'color' => 'from-emerald-500 to-teal-600', 'bg' => 'text-emerald-600'],
            'This week' => ['val' => $weekly, 'color' => 'from-indigo-500 to-blue-600', 'bg' => 'text-indigo-600'],
            'This month' => ['val' => $monthly, 'color' => 'from-purple-500 to-pink-600', 'bg' => 'text-purple-600'],
            'Gross revenue' => ['val' => $gross, 'color' => 'from-amber-500 to-orange-600', 'bg' => 'text-amber-600']
        ] as $label => $meta)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $label }}</div>
                <div class="text-2xl sm:text-3xl font-extrabold {{ $meta['bg'] }} mt-2">
                    {{ number_format($meta['val']) }} <span class="text-xs text-gray-400 font-normal">PKR</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Payment status ratio --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h2 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
            </svg>
            Payment Status Ratio Breakdown
        </h2>
        <ul class="space-y-3">
            @foreach ($statusRatio as $status => $count)
                <li class="flex items-center justify-between text-xs p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="font-semibold text-gray-800">{{ ucfirst(str_replace('_',' ',$status)) }}</span>
                    <span class="font-extrabold px-3 py-1 bg-white rounded-lg shadow-xs text-indigo-600 border border-gray-100">{{ $count }} orders</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
