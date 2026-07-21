<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookish Admin — @yield('title', 'Dashboard')</title>
    <meta name="description" content="Bookish Admin Panel - Manage your bookstore with ease">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- tailwind cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- select2 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ---- Sidebar ---- */
        .sidebar {
            background: linear-gradient(180deg, #0f0f1a 0%, #13131f 60%, #0f0f1a 100%);
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: width 0.3s ease;
        }

        .sidebar-brand {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-icon {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            padding: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        /* ---- Nav Links ---- */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            color: #9ca3af;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #c4b5fd;
        }

        .nav-link:hover .nav-icon {
            color: #8b5cf6;
            transform: scale(1.1);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(139, 92, 246, 0.15));
            color: #a78bfa;
            border: 1px solid rgba(99, 102, 241, 0.3);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.1);
        }

        .nav-link.active .nav-icon {
            color: #8b5cf6;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            transition: all 0.2s ease;
            color: #6b7280;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #4b5563;
            padding: 0 12px;
            margin: 8px 0 4px;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 8px 0;
        }

        /* ---- Main Content ---- */
        .main-content {
            background: #f8f9ff;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #e8eaf0;
            box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }

        /* ---- Alerts ---- */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fca5a5;
            color: #991b1b;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ---- Logout button ---- */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 10px;
            color: #ef4444;
            font-size: 0.82rem;
            font-weight: 500;
            width: 100%;
            text-align: left;
            transition: all 0.2s ease;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* ---- Scrollbar ---- */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 2px; }

        /* ---- Tooltip ---- */
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 10px;
        }

        /* ---- Page transition ---- */
        .main-content main { animation: fadeInUp 0.3s ease; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ---- Select2 override ---- */
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            height: 38px;
            padding: 4px 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: #111827;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">
<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar w-60 flex flex-col overflow-y-auto overflow-x-hidden flex-shrink-0">

        {{-- Brand --}}
        <div class="p-4 pb-3 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 7h6M9 11h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="sidebar-brand text-base font-800 tracking-tight leading-none">Bookish</div>
                    <div class="text-gray-600 text-xs mt-0.5 font-medium">Admin Panel</div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-3 space-y-0.5">

            <div class="nav-section-label">Main</div>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                </svg>
                Dashboard
            </a>

            <div class="nav-section-label">Catalog</div>

            {{-- Products --}}
            <a href="{{ route('admin.products.index') }}"
               class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 7h6M9 11h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Products
            </a>

            {{-- Categories --}}
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="7" cy="6" r="1.5" fill="currentColor"/>
                    <circle cx="7" cy="12" r="1.5" fill="currentColor"/>
                    <circle cx="7" cy="18" r="1.5" fill="currentColor"/>
                </svg>
                Categories
            </a>

            {{-- Attributes --}}
            <a href="{{ route('admin.attributes.index') }}"
               class="nav-link {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 7h.01M7 3h5a1.99 1.99 0 0 1 1.414.586l7 7a2 2 0 0 1 0 2.828l-7 7a2 2 0 0 1-2.828 0l-7-7A1.994 1.994 0 0 1 3 12V7a4 4 0 0 1 4-4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Product Attribute
            </a>

            {{-- Bundles --}}
            <a href="{{ route('admin.bundles.index') }}"
               class="nav-link {{ request()->routeIs('admin.bundles.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <line x1="12" y1="22.08" x2="12" y2="12" stroke="currentColor" stroke-width="1.8"/>
                </svg>
                Bundles
            </a>

            <div class="nav-section-label">Institutions</div>

            {{-- Schools --}}
            <a href="{{ route('admin.schools.index') }}"
               class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <polyline points="9 22 9 12 15 12 15 22" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
                Schools
            </a>

            {{-- Classes --}}
            <a href="{{ route('admin.classes.index') }}"
               class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Classes
            </a>

            <div class="nav-section-label">Commerce</div>

            {{-- Orders --}}
            <a href="{{ route('admin.orders.index') }}"
               class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M16 10a4 4 0 0 1-8 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Orders
            </a>

            {{-- Payments --}}
            <a href="{{ route('admin.payments.index') }}"
               class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" stroke="currentColor" stroke-width="1.8"/>
                    <line x1="1" y1="10" x2="23" y2="10" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M6 15h2M6 12h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Payment Verification
            </a>

            {{-- Customers --}}
            <a href="{{ route('admin.customers.index') }}"
               class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/>
                </svg>
                Customers
            </a>

            <div class="nav-section-label">Store</div>

            {{-- Inventory --}}
            <a href="{{ route('admin.inventory.index') }}"
               class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Inventory
            </a>

            {{-- Banners --}}
            <a href="{{ route('admin.banners.index') }}"
               class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                    <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
                Banners
            </a>

            {{-- Shipping --}}
            <a href="{{ route('admin.shipping.index') }}"
               class="nav-link {{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="3" width="15" height="13" rx="1" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M16 8h4l3 3v5h-7V8z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <circle cx="5.5" cy="18.5" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="18.5" cy="18.5" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                </svg>
                Shipping Charges
            </a>

            {{-- Contacts --}}
            <a href="{{ route('admin.contacts.index') }}"
               class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
                Contacts
            </a>

            {{-- Super Admin Section --}}
            @if (auth()->user()?->isSuperAdmin())
                <div class="nav-divider"></div>
                <div class="nav-section-label" style="color:#7c3aed;">Super Admin</div>

                <a href="{{ route('admin.finance.index') }}"
                   class="nav-link {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="12" y1="1" x2="12" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Finance
                </a>

                <a href="{{ route('admin.admins.index') }}"
                   class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                    Admin Users
                </a>

                <a href="{{ route('admin.settings.edit') }}"
                   class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                    Bank Settings
                </a>
            @endif

        </nav>

        {{-- Bottom: Logout --}}
        <div class="px-3 pb-4 border-t border-white/5 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content flex-1 flex flex-col">

        {{-- Top Bar --}}
        <div class="topbar px-8 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-gray-900 font-700 text-lg leading-none">@yield('title', 'Dashboard')</h2>
                <p class="text-gray-400 text-xs mt-0.5">Bookish Admin Panel</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="text-sm font-600 text-gray-700">{{ auth()->user()?->name ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-400">{{ auth()->user()?->isSuperAdmin() ? 'Super Admin' : 'Administrator' }}</div>
                </div>
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-700 text-sm shadow-md">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Page Content --}}
        <main class="flex-1 px-8 py-6">

            @if (session('success'))
                <div class="alert-success mb-5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error mb-5">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('.select2-single').select2();
    });
</script>

</body>
</html>
