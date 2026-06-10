@extends('admin.layout')
@section('title','Admin Users')
@section('content')
<h1 class="text-2xl font-bold mb-6">Admin Users</h1>
<form method="POST" action="{{ route('admin.admins.store') }}" class="bg-white p-4 rounded-lg shadow grid sm:grid-cols-5 gap-2 mb-6">
    @csrf
    <input name="name" placeholder="Name" required class="border rounded px-3 py-2">
    <input name="mobile" placeholder="Mobile" required class="border rounded px-3 py-2">
    <input name="email" placeholder="Email" class="border rounded px-3 py-2">
    <select name="role" class="border rounded px-3 py-2"><option value="admin">admin</option><option value="super_admin">super_admin</option></select>
    <input name="password" type="password" placeholder="Password" required class="border rounded px-3 py-2">
    <button class="bg-indigo-600 text-white px-4 rounded sm:col-span-5">Create Admin</button>
</form>
<div class="bg-white rounded-lg shadow divide-y">
@foreach ($admins as $a)
    <div class="flex items-center justify-between p-3 text-sm">
        <span>{{ $a->name }} — {{ $a->mobile }} <span class="text-gray-400">({{ $a->role }})</span></span>
        <form method="POST" action="{{ route('admin.admins.revoke', $a) }}" onsubmit="return confirm('Revoke access?')">@csrf<button class="text-red-500">Revoke</button></form>
    </div>
@endforeach
</div>
@endsection
