@extends('admin.layout')
@section('title', 'Admin Users')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Admin Users</h1>
                <p class="text-xs text-gray-500 mt-0.5">Manage administrator accounts and security roles</p>
            </div>
        </div>
    </div>

    {{-- Create Form --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h2 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Create New Admin User
        </h2>
        <form method="POST" action="{{ route('admin.admins.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Full Name</label>
                <input name="name" placeholder="John Doe" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Mobile Number</label>
                <input name="mobile" placeholder="03001234567" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Email Address</label>
                <input name="email" type="email" placeholder="admin@bookish.com" class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Role</label>
                <select name="role" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Password</label>
                <input name="password" type="password" placeholder="••••••••" required class="w-full border border-gray-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
            <div class="sm:col-span-2 lg:col-span-5 pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow-md shadow-indigo-500/20 active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Administrator
                </button>
            </div>
        </form>
    </div>

    {{-- Admin List --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900 text-sm">Active Administrator Accounts</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach ($admins as $a)
                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50/60 transition-colors">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($a->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                                {{ $a->name }}
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $a->role === 'super_admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                                    {{ str_replace('_', ' ', $a->role) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-3">
                                <span>📱 {{ $a->mobile }}</span>
                                @if($a->email)
                                    <span>✉️ {{ $a->email }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        @if(auth()->id() !== $a->id)
                            <form method="POST" action="{{ route('admin.admins.revoke', $a) }}" onsubmit="return confirm('Are you sure you want to revoke access for {{ $a->name }}?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Revoke
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 font-medium italic">Current User</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
