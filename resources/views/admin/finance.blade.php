@extends('admin.layout')
@section('title','Finance')
@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Finance</h1>
    <a href="{{ route('admin.finance.export') }}" class="bg-gray-900 text-white px-4 py-2 rounded">Export CSV</a>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach (['Today'=>$daily,'This week'=>$weekly,'This month'=>$monthly,'Gross revenue'=>$gross] as $label=>$val)
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-2xl font-bold text-indigo-600">{{ number_format($val) }} <span class="text-sm">PKR</span></div>
            <div class="text-sm text-gray-500 mt-1">{{ $label }}</div>
        </div>
    @endforeach
</div>
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="font-semibold mb-3">Payment status ratio</h2>
    <ul class="text-sm space-y-1">
        @foreach ($statusRatio as $status => $count)
            <li class="flex justify-between"><span>{{ ucfirst(str_replace('_',' ',$status)) }}</span><span>{{ $count }}</span></li>
        @endforeach
    </ul>
</div>
@endsection
