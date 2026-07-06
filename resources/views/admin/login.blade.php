<!DOCTYPE html><html><head><meta charset="utf-8"><title>Admin Login</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<form method="POST" action="{{ route('admin.login.attempt') }}" class="bg-white p-8 rounded-lg shadow w-80 space-y-4">
    @csrf
    <h1 class="text-xl font-bold">Admin Login</h1>
    @if($errors->any())<p class="text-red-500 text-sm">{{ $errors->first() }}</p>@endif
    <input name="mobile" placeholder="Mobile" required class="w-full border rounded px-3 py-2">
    <input name="password" type="password" placeholder="Password" required class="w-full border rounded px-3 py-2">
    <button class="w-full bg-gray-900 text-white py-2 rounded">Login</button>
</form></body></html>
