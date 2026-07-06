@extends('admin.layout')
@section('title','Customers')
@section('content')
<h1 class="text-2xl font-bold mb-6">Customers</h1>
<div class="bg-white rounded-lg shadow overflow-x-auto">
<table class="w-full text-sm"><thead class="bg-gray-50 text-left"><tr>
<th class="p-3">Name</th><th class="p-3">Mobile</th><th class="p-3">Orders</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead>
<tbody class="divide-y">
@foreach ($customers as $c)
<tr>
    <td class="p-3">{{ $c->name }}</td><td class="p-3">{{ $c->mobile }}</td><td class="p-3">{{ $c->orders_count }}</td>
    <td class="p-3">{{ $c->is_blocked ? 'Blocked' : 'Active' }}</td>
    <td class="p-3"><form method="POST" action="{{ route('admin.customers.toggleBlock', $c) }}">@csrf<button class="text-indigo-600">{{ $c->is_blocked ? 'Unblock' : 'Block' }}</button></form></td>
</tr>
@endforeach
</tbody></table></div>
<div class="mt-4">{{ $customers->links() }}</div>
@endsection
