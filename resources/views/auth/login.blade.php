@extends('layouts.app')
@section('content')
<div class="max-w-sm mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold mb-4">Login</h1>

    @if (! session('otp_sent'))
        <form method="POST" action="{{ route('login.sendOtp') }}" class="space-y-4">
            @csrf
            <input name="mobile" placeholder="03XXXXXXXXX" required class="w-full border rounded px-3 py-2">
            <button class="w-full bg-indigo-600 text-white py-2 rounded">Send OTP</button>
        </form>
    @else
        <form method="POST" action="{{ route('login.verifyOtp') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="mobile" value="{{ session('mobile') }}">
            <p class="text-sm text-gray-500">Code sent via {{ session('channel') }}.
                @if(session('debug_code'))<br><span class="text-indigo-600">DEV code: {{ session('debug_code') }}</span>@endif
            </p>
            <input name="code" maxlength="6" placeholder="6-digit code" required class="w-full border rounded px-3 py-2 tracking-widest text-center">
            @error('code')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            <button class="w-full bg-indigo-600 text-white py-2 rounded">Verify & Login</button>
        </form>
    @endif
</div>
@endsection
