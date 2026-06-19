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
        <aside class="w-60 bg-gray-900 text-gray-300 p-4 space-y-1 text-sm">
            <div class="text-white font-bold text-lg mb-4 px-2">Bookish Admin</div>
            @php $r = request()->routeIs(...); @endphp
            @foreach ([
        'admin.dashboard' => 'Dashboard',
        'admin.products.index' => 'Products',
        'admin.categories.index' => 'Categories',
        'admin.schools.index' => 'Schools',
        'admin.classes.index' => 'Classes',
        'admin.bundles.index' => 'Bundles',
        'admin.orders.index' => 'Orders',
        'admin.payments.index' => 'Payment Verification',
        'admin.customers.index' => 'Customers',
        'admin.inventory.index' => 'Inventory',
        'admin.banners.index' => 'Banners',
    ] as $route => $label)
                <a href="{{ route($route) }}"
                    class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs($route) ? 'bg-gray-800 text-white' : '' }}">{{ $label }}</a>
            @endforeach
            @if (auth()->user()?->isSuperAdmin())
                <div class="pt-3 mt-3 border-t border-gray-700 text-xs uppercase text-gray-500 px-3">Super Admin</div>
                <a href="{{ route('admin.finance.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-800">Finance</a>
                <a href="{{ route('admin.admins.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Admin
                    Users</a>
                <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Bank
                    Settings</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="pt-4">@csrf
                <button class="px-3 py-2 text-red-400">Logout</button>
            </form>
        </aside>
        <main class="flex-1 p-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>
