@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Welcome Hero Section --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 text-white p-6 sm:p-8 shadow-xl border border-indigo-700/30">
        <div class="absolute right-0 top-0 -mt-10 -mr-10 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 bottom-0 -mb-10 w-60 h-60 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 text-xs font-semibold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Bookish Overview
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Welcome Back, {{ auth()->user()?->name ?? 'Admin' }} 👋
                </h1>
                <p class="text-indigo-200/80 text-sm mt-1.5 max-w-xl">
                    Here's what's happening with your bookstore today. You have <strong class="text-amber-300 font-bold">{{ $pendingProofs }} payment proofs</strong> waiting for verification.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-white text-indigo-950 hover:bg-indigo-50 font-semibold px-4 py-2.5 rounded-xl text-sm transition-all shadow-md hover:shadow-lg active:scale-95">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Product
                </a>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 bg-indigo-600/60 hover:bg-indigo-600 text-white font-medium px-4 py-2.5 rounded-xl text-sm transition-all border border-indigo-400/30">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View Orders
                </a>
            </div>
        </div>
    </div>

    {{-- Key Metrics Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Card 1: Pending Payment Proofs --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 transition-all duration-200 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pending Proofs</span>
                    <div class="text-3xl font-extrabold text-amber-600 mt-2 tracking-tight">{{ $pendingProofs }}</div>
                    <div class="inline-flex items-center gap-1 text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full mt-2 font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Needs verification
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-md shadow-amber-500/20 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.payments.index') }}" class="mt-4 flex items-center text-xs font-medium text-amber-600 hover:text-amber-700 gap-1 pt-3 border-t border-gray-100">
                Review proofs
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Card 2: Orders Awaiting Payment --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 transition-all duration-200 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Awaiting Payment</span>
                    <div class="text-3xl font-extrabold text-indigo-600 mt-2 tracking-tight">{{ $pendingOrders }}</div>
                    <div class="inline-flex items-center gap-1 text-xs text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full mt-2 font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Pending orders
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="mt-4 flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-700 gap-1 pt-3 border-t border-gray-100">
                View all orders
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Card 3: Low-Stock Products --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 transition-all duration-200 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Low Stock Products</span>
                    <div class="text-3xl font-extrabold text-rose-600 mt-2 tracking-tight">{{ $lowStock }}</div>
                    <div class="inline-flex items-center gap-1 text-xs text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full mt-2 font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Needs re-stocking
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.inventory.index') }}" class="mt-4 flex items-center text-xs font-medium text-rose-600 hover:text-rose-700 gap-1 pt-3 border-t border-gray-100">
                Manage inventory
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Card 4: Total Products --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 transition-all duration-200 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Products</span>
                    <div class="text-3xl font-extrabold text-emerald-600 mt-2 tracking-tight">{{ $totalProducts }}</div>
                    <div class="inline-flex items-center gap-1 text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full mt-2 font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        In catalog
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.products.index') }}" class="mt-4 flex items-center text-xs font-medium text-emerald-600 hover:text-emerald-700 gap-1 pt-3 border-t border-gray-100">
                Browse catalog
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>

    {{-- Admin Modules SVG Shortcuts Grid --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Admin Modules</h2>
                <p class="text-gray-500 text-xs mt-0.5">Quick access to all bookstore management modules</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">

            {{-- Module: Products --}}
            <a href="{{ route('admin.products.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">Products</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Manage books</span>
            </a>

            {{-- Module: Categories --}}
            <a href="{{ route('admin.categories.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">Categories</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Book genres</span>
            </a>

            {{-- Module: Schools --}}
            <a href="{{ route('admin.schools.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Schools</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Institutions</span>
            </a>

            {{-- Module: Bundles --}}
            <a href="{{ route('admin.bundles.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-amber-600 transition-colors">Bundles</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Syllabus packages</span>
            </a>

            {{-- Module: Orders --}}
            <a href="{{ route('admin.orders.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Orders</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Customer orders</span>
            </a>

            {{-- Module: Payment Verification --}}
            <a href="{{ route('admin.payments.index') }}" class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-800 group-hover:text-rose-600 transition-colors">Payments</span>
                <span class="text-[11px] text-gray-400 mt-0.5">Verify proofs</span>
            </a>

        </div>
    </div>

    {{-- Recent Orders Table & Quick Summary Section --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-base">Recent Orders</h3>
                <p class="text-xs text-gray-500 mt-0.5">Latest transactions placed on Bookish</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                View All Orders
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50/70 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Order ID</th>
                        <th class="px-6 py-3.5">Customer</th>
                        <th class="px-6 py-3.5">Total Amount</th>
                        <th class="px-6 py-3.5">Order Status</th>
                        <th class="px-6 py-3.5">Payment Status</th>
                        <th class="px-6 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                #{{ $order->order_number ?? $order->id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $order->customer_name ?? 'Guest' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $order->mobile ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ number_format($order->total_amount ?? 0, 2) }} PKR
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold
                                    @if(($order->order_status ?? '') == 'completed') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif(($order->order_status ?? '') == 'pending_payment') bg-amber-50 text-amber-700 border border-amber-200
                                    @elseif(($order->order_status ?? '') == 'cancelled') bg-rose-50 text-rose-700 border border-rose-200
                                    @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->order_status ?? 'Pending')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold
                                    @if(($order->payment_status ?? '') == 'verified' || ($order->payment_status ?? '') == 'paid') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif(($order->payment_status ?? '') == 'proof_submitted') bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status ?? 'Unpaid')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                No recent orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
