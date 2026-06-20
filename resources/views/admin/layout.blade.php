<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookish Admin — @yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }

        /* Sidebar */
        .sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }
        .nav-link { display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; font-size:13.5px; font-weight:500; color:#94a3b8; transition:all 0.18s; }
        .nav-link:hover { background:rgba(255,255,255,0.07); color:#e2e8f0; }
        .nav-link.active { background:linear-gradient(90deg,#6366f1,#4f46e5); color:#fff; box-shadow:0 4px 14px rgba(99,102,241,0.35); }
        .nav-link i { width:18px; text-align:center; font-size:14px; }
        .nav-section { font-size:10px; text-transform:uppercase; letter-spacing:.08em; color:#475569; padding:16px 14px 6px; font-weight:600; }

        /* Main content */
        .main-bg { background:#f1f5f9; }

        /* Stat cards */
        .stat-card { background:#fff; border-radius:16px; padding:20px 22px; box-shadow:0 1px 4px rgba(0,0,0,.06), 0 4px 24px rgba(0,0,0,.04); border:1px solid #e2e8f0; transition:transform 0.18s, box-shadow 0.18s; }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(0,0,0,.09); }
        .stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }

        /* Alert badge */
        .badge-pulse { animation:pulse 2s cubic-bezier(.4,0,.6,1) infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.6} }

        /* Table */
        table th { font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:#64748b; font-weight:600; }
        table td { font-size:13px; }

        /* Scrollbar */
        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-track { background:#1e293b; }
        ::-webkit-scrollbar-thumb { background:#334155; border-radius:99px; }

        /* Top bar */
        .topbar { background:#fff; border-bottom:1px solid #e2e8f0; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0f172a',
                        brand: '#6366f1',
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full bg-slate-100 text-slate-800">
<div class="flex h-screen overflow-hidden">

    {{-- ════════════════════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════════════════════ --}}
    <aside class="sidebar w-64 flex flex-col flex-shrink-0 h-full overflow-y-auto">

        {{-- Brand --}}
        <div class="px-5 py-5 flex items-center gap-3 border-b border-white/5">
            <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-lg">B</div>
            <div>
                <div class="text-white font-bold text-sm leading-tight">Bookish Admin</div>
                <div class="text-slate-400 text-[10px] font-medium">Management Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">

            <div class="nav-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney"></i> Dashboard
            </a>

            <div class="nav-section mt-2">Catalogue</div>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Categories
            </a>
            <a href="{{ route('admin.bundles.index') }}" class="nav-link {{ request()->routeIs('admin.bundles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cubes"></i> Bundles
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                <i class="fa-solid fa-warehouse"></i> Inventory
            </a>

            <div class="nav-section mt-2">Sales</div>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> Orders
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Payments
                @php $pendingProofsCount = \App\Models\Order::where('payment_status','proof_submitted')->count(); @endphp
                @if($pendingProofsCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold rounded-full px-1.5 py-0.5 badge-pulse">{{ $pendingProofsCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Customers
            </a>

            <div class="nav-section mt-2">Content</div>
            <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                <i class="fa-solid fa-school"></i> Schools
            </a>
            <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-teacher"></i> Classes
            </a>
            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="fa-solid fa-image"></i> Banners
            </a>

            @if(auth()->user()?->isSuperAdmin())
                <div class="nav-section mt-2">Super Admin</div>
                <a href="{{ route('admin.finance.index') }}" class="nav-link {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Finance
                </a>
                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-shield"></i> Admin Users
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Contact Messages
                </a>
            @endif

        </nav>

        {{-- Logout --}}
        <div class="px-3 pb-4 border-t border-white/5 pt-3">
            <div class="flex items-center gap-3 px-3 py-2 mb-2">
                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white text-xs font-semibold truncate">{{ auth()->user()?->name ?? 'Admin' }}</div>
                    <div class="text-slate-400 text-[10px] truncate">{{ auth()->user()?->role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="nav-link w-full text-red-400 hover:text-red-300 hover:bg-red-900/20">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ════════════════════════════════════════════════════════
         MAIN AREA
    ═══════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="topbar px-6 py-3.5 flex items-center justify-between flex-shrink-0">
            <div>
                <h2 class="font-bold text-slate-800 text-base">@yield('title', 'Dashboard')</h2>
                <p class="text-slate-400 text-xs">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-4">
                {{-- Quick search --}}
                <div class="hidden md:flex items-center gap-2 bg-slate-100 rounded-xl px-3 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Quick search..." class="bg-transparent text-sm text-slate-600 outline-none w-40 placeholder:text-slate-400">
                </div>
                {{-- Alerts --}}
                @php $alerts = \App\Models\Order::where('payment_status','proof_submitted')->count(); @endphp
                <div class="relative">
                    <a href="{{ route('admin.payments.index') }}" class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </a>
                    @if($alerts > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center badge-pulse">{{ $alerts }}</span>
                    @endif
                </div>
                {{-- View Site --}}
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> View Site
                </a>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-6 pt-3">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if($errors->any())
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-3 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    {{ $errors->first() }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-6 py-4">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
