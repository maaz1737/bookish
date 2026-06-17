<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookish Admin — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-gray-300 p-4 flex flex-col justify-between text-sm shadow-xl">
            <div class="space-y-1">
                <div
                    class="text-white font-bold text-xl mb-6 px-2 tracking-wide border-b border-gray-800 pb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Bookish Admin
                </div>

                @php
                    $menuItems = [
                        'admin.dashboard' => [
                            'label' => 'Dashboard',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>',
                        ],
                        'admin.products.index' => [
                            'label' => 'Products',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>',
                        ],
                        'admin.categories.index' => [
                            'label' => 'Categories',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>',
                        ],
                        'admin.schools.index' => [
                            'label' => 'Schools',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>',
                        ],
                        'admin.classes.index' => [
                            'label' => 'Classes',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>',
                        ],
                        'admin.bundles.index' => [
                            'label' => 'Bundles',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
                        ],
                        'admin.orders.index' => [
                            'label' => 'Orders',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>',
                        ],
                        'admin.payments.index' => [
                            'label' => 'Payment Verification',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                        ],
                        'admin.customers.index' => [
                            'label' => 'Customers',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                        ],
                        'admin.inventory.index' => [
                            'label' => 'Inventory',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                        ],
                        // Added: Contact Messages Module Route
                        'admin.contacts.index' => [
                            'label' => 'Contact Messages',
                            'icon' =>
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>',
                        ],
                    ];
                @endphp

                @foreach ($menuItems as $route => $data)
                    <a href="{{ route($route) }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded transition duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs($route) ? 'bg-gray-800 text-white font-semibold border-l-4 border-indigo-500 pl-2' : '' }}">
                        {!! $data['icon'] !!}
                        <span>{{ $data['label'] }}</span>
                    </a>
                @endforeach

                @if (auth()->user()?->isSuperAdmin())
                    <div
                        class="pt-4 mt-4 border-t border-gray-800 text-xs uppercase tracking-wider text-gray-500 px-3 font-semibold">
                        Super Admin</div>

                    <a href="{{ route('admin.finance.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded transition duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.finance.*') ? 'bg-gray-800 text-white font-semibold' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Finance</span>
                    </a>

                    <a href="{{ route('admin.admins.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded transition duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.admins.*') ? 'bg-gray-800 text-white font-semibold' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Admin Users</span>
                    </a>

                    <a href="{{ route('admin.settings.edit') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded transition duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.settings.*') ? 'bg-gray-800 text-white font-semibold' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                        </svg>
                        <span>Bank Settings</span>
                    </a>
                @endif
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-800 mt-4">
                @csrf
                <button
                    class="flex items-center gap-3 w-full px-3 py-2.5 text-red-400 hover:bg-gray-800 hover:text-red-300 rounded transition duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </aside>

        <main class="flex-1 p-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded-r shadow-sm">
                    {{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-800 border-l-4 border-red-500 rounded-r shadow-sm">
                    {{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
