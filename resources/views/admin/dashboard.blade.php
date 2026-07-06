@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ([
        'Pending payment proofs'=>$pendingProofs,'Orders awaiting payment'=>$pendingOrders,
        'Low-stock products'=>$lowStock,'Total products'=>$totalProducts,
    ] as $label=>$value)
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-3xl font-bold text-indigo-600">{{ $value }}</div>
            <div class="text-sm text-gray-500 mt-1">{{ $label }}</div>
        </div>
    @endforeach
</div>
@endsection
