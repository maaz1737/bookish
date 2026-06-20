@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')

{{-- ══════════════════════════════════════════════════════════
     TOP STAT CARDS
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Revenue --}}
    <div class="stat-card col-span-2 lg:col-span-1">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Gross Revenue</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">PKR {{ number_format($grossRevenue) }}</p>
                <p class="text-xs text-slate-400 mt-1">Today: <span class="text-emerald-600 font-semibold">PKR {{ number_format($todayRevenue) }}</span></p>
            </div>
            <div class="stat-icon bg-emerald-50 text-emerald-600">
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
            </div>
        </div>
        <div class="mt-3 h-1 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-1 bg-emerald-400 rounded-full" style="width: {{ $grossRevenue > 0 ? min(100, ($monthRevenue/$grossRevenue)*100) : 0 }}%"></div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1">This month: PKR {{ number_format($monthRevenue) }}</p>
    </div>

    {{-- Total Orders --}}
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Total Orders</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalOrders }}</p>
                <p class="text-xs text-slate-400 mt-1">Delivered: <span class="text-indigo-600 font-semibold">{{ $deliveredOrders }}</span></p>
            </div>
            <div class="stat-icon bg-indigo-50 text-indigo-600">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
        <div class="mt-3 flex gap-1">
            <span class="text-[10px] bg-yellow-100 text-yellow-700 font-semibold px-2 py-0.5 rounded-full">{{ $pendingOrders }} Pending</span>
            <span class="text-[10px] bg-blue-100 text-blue-700 font-semibold px-2 py-0.5 rounded-full">{{ $processingOrders }} Processing</span>
        </div>
    </div>

    {{-- Products --}}
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Products</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalProducts }}</p>
                <p class="text-xs text-slate-400 mt-1">Active: <span class="text-emerald-600 font-semibold">{{ $activeProducts }}</span></p>
            </div>
            <div class="stat-icon bg-amber-50 text-amber-600">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>
        <div class="mt-3 flex gap-1">
            @if($lowStock > 0)
                <a href="{{ route('admin.inventory.index') }}" class="text-[10px] bg-red-100 text-red-700 font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 badge-pulse">
                    <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> {{ $lowStock }} Low Stock
                </a>
            @else
                <span class="text-[10px] bg-emerald-100 text-emerald-700 font-semibold px-2 py-0.5 rounded-full">All stocked ✓</span>
            @endif
        </div>
    </div>

    {{-- Payment Proofs --}}
    <div class="stat-card {{ $pendingProofs > 0 ? 'ring-2 ring-red-200' : '' }}">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Pending Proofs</p>
                <p class="text-2xl font-extrabold {{ $pendingProofs > 0 ? 'text-red-600' : 'text-slate-800' }} mt-1">{{ $pendingProofs }}</p>
                <p class="text-xs text-slate-400 mt-1">Need verification</p>
            </div>
            <div class="stat-icon {{ $pendingProofs > 0 ? 'bg-red-50 text-red-500' : 'bg-slate-50 text-slate-400' }}">
                <i class="fa-solid fa-file-invoice {{ $pendingProofs > 0 ? 'badge-pulse' : '' }}"></i>
            </div>
        </div>
        @if($pendingProofs > 0)
            <a href="{{ route('admin.payments.index') }}" class="mt-3 text-[11px] text-red-600 font-semibold hover:underline flex items-center gap-1">
                Review now <i class="fa-solid fa-arrow-right text-[9px]"></i>
            </a>
        @else
            <p class="mt-3 text-[10px] text-emerald-600 font-semibold">All clear ✓</p>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════
     CHART + ORDER STATUS
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    {{-- Revenue Trend Chart --}}
    <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-slate-800">Revenue Trend</h3>
                <p class="text-xs text-slate-400">Last 7 days</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                    <span class="w-2.5 h-2.5 bg-indigo-500 rounded-full inline-block"></span> Revenue
                </span>
            </div>
        </div>
        <canvas id="revenueChart" height="120"></canvas>
    </div>

    {{-- Order Status Donut --}}
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <div class="mb-4">
            <h3 class="font-bold text-slate-800">Order Status</h3>
            <p class="text-xs text-slate-400">All time breakdown</p>
        </div>
        <canvas id="statusChart" height="160"></canvas>
        <div class="mt-4 space-y-2">
            @php
                $statusColors = [
                    'pending_payment' => ['bg-yellow-400','Pending Payment'],
                    'processing'      => ['bg-blue-400',  'Processing'],
                    'shipped'         => ['bg-indigo-400', 'Shipped'],
                    'delivered'       => ['bg-emerald-400','Delivered'],
                    'cancelled'       => ['bg-red-400',    'Cancelled'],
                ];
            @endphp
            @foreach($statusColors as $key => [$color, $label])
                @php $count = $orderStatusCounts[$key] ?? 0; @endphp
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $color }} inline-block"></span>
                        <span class="text-slate-600 font-medium">{{ $label }}</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════
     RECENT ORDERS + TOP PRODUCTS
═══════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    {{-- Recent Orders Table --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-800">Recent Orders</h3>
                <p class="text-xs text-slate-400">Latest 8 orders</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline flex items-center gap-1">
                View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Order #</th>
                        <th class="px-3 py-3 text-left">Customer</th>
                        <th class="px-3 py-3 text-left">Amount</th>
                        <th class="px-3 py-3 text-left">Payment</th>
                        <th class="px-3 py-3 text-left">Status</th>
                        <th class="px-3 py-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 font-semibold hover:underline text-xs">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-3 py-3 text-slate-700 font-medium">{{ Str::limit($order->customer_name, 14) }}</td>
                            <td class="px-3 py-3 font-semibold text-slate-800">PKR {{ number_format($order->total_amount) }}</td>
                            <td class="px-3 py-3">
                                @php
                                    $ps = $order->payment_status;
                                    $psBadge = match($ps) {
                                        'paid'           => 'bg-emerald-100 text-emerald-700',
                                        'proof_submitted'=> 'bg-yellow-100 text-yellow-700',
                                        'pending'        => 'bg-slate-100 text-slate-600',
                                        default          => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $psBadge }}">{{ str_replace('_',' ', ucfirst($ps)) }}</span>
                            </td>
                            <td class="px-3 py-3">
                                @php
                                    $os = $order->order_status;
                                    $osBadge = match($os) {
                                        'delivered'     => 'bg-emerald-100 text-emerald-700',
                                        'shipped'       => 'bg-indigo-100 text-indigo-700',
                                        'processing'    => 'bg-blue-100 text-blue-700',
                                        'pending_payment'=> 'bg-yellow-100 text-yellow-700',
                                        'cancelled'     => 'bg-red-100 text-red-600',
                                        default         => 'bg-slate-100 text-slate-500',
                                    };
                                @endphp
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $osBadge }}">{{ str_replace('_',' ', ucfirst($os)) }}</span>
                            </td>
                            <td class="px-3 py-3 text-slate-400 text-[11px]">{{ $order->created_at->format('d M, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-receipt text-3xl mb-2 block text-slate-200"></i>
                                No orders yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Stats + Low Stock Products --}}
    <div class="flex flex-col gap-4">

        {{-- Quick Info Cards --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 mb-4">Quick Stats</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="fa-solid fa-school text-indigo-400 w-4 text-center"></i> Categories
                    </div>
                    <span class="font-bold text-slate-800">{{ $totalCategories }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="fa-solid fa-users text-blue-400 w-4 text-center"></i> Customers
                    </div>
                    <span class="font-bold text-slate-800">{{ $totalCustomers }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="fa-solid fa-box-open text-amber-400 w-4 text-center"></i> Active Products
                    </div>
                    <span class="font-bold text-slate-800">{{ $activeProducts }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="fa-solid fa-check-circle text-emerald-400 w-4 text-center"></i> Delivered
                    </div>
                    <span class="font-bold text-slate-800">{{ $deliveredOrders }}</span>
                </div>
            </div>
        </div>

        {{-- Low Stock Alert --}}
        @if($topProducts->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex-1">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-800 text-sm">⚠️ Lowest Stock</h3>
                <a href="{{ route('admin.inventory.index') }}" class="text-[11px] text-indigo-600 font-semibold hover:underline">Manage</a>
            </div>
            <div class="space-y-2.5">
                @foreach($topProducts as $p)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                            @if(!empty($p->images) && count($p->images) > 0)
                                <img src="{{ asset('storage/'.$p->images[0]) }}" class="w-8 h-8 object-cover rounded-lg">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-700 truncate">{{ $p->name }}</p>
                            <div class="flex items-center gap-1 mt-0.5">
                                <div class="h-1.5 flex-1 bg-slate-100 rounded-full overflow-hidden">
                                    @php $pct = $p->low_stock_threshold > 0 ? min(100, ($p->stock / max($p->stock, $p->low_stock_threshold*3)) * 100) : 50; @endphp
                                    <div class="h-1.5 rounded-full {{ $p->stock <= $p->low_stock_threshold ? 'bg-red-400' : 'bg-amber-400' }}" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="text-[10px] font-bold {{ $p->stock <= $p->low_stock_threshold ? 'text-red-500' : 'text-amber-500' }}">{{ $p->stock }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════
     MODULE QUICK ACCESS GRID
═══════════════════════════════════════════════════════════ --}}
<div class="mb-6">
    <h3 class="font-bold text-slate-700 text-sm mb-3 px-1">Quick Access</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        @php
            $modules = [
                ['route'=>'admin.products.index',   'icon'=>'fa-box-open',             'label'=>'Products',    'color'=>'bg-amber-50 text-amber-600 border-amber-100'],
                ['route'=>'admin.categories.index', 'icon'=>'fa-layer-group',           'label'=>'Categories',  'color'=>'bg-purple-50 text-purple-600 border-purple-100'],
                ['route'=>'admin.orders.index',     'icon'=>'fa-receipt',               'label'=>'Orders',      'color'=>'bg-indigo-50 text-indigo-600 border-indigo-100'],
                ['route'=>'admin.payments.index',   'icon'=>'fa-file-invoice-dollar',   'label'=>'Payments',    'color'=>'bg-green-50 text-green-600 border-green-100'],
                ['route'=>'admin.inventory.index',  'icon'=>'fa-warehouse',             'label'=>'Inventory',   'color'=>'bg-red-50 text-red-600 border-red-100'],
                ['route'=>'admin.bundles.index',    'icon'=>'fa-cubes',                 'label'=>'Bundles',     'color'=>'bg-teal-50 text-teal-600 border-teal-100'],
                ['route'=>'admin.schools.index',    'icon'=>'fa-school',                'label'=>'Schools',     'color'=>'bg-blue-50 text-blue-600 border-blue-100'],
                ['route'=>'admin.customers.index',  'icon'=>'fa-users',                 'label'=>'Customers',   'color'=>'bg-pink-50 text-pink-600 border-pink-100'],
                ['route'=>'admin.banners.index',    'icon'=>'fa-image',                 'label'=>'Banners',     'color'=>'bg-orange-50 text-orange-600 border-orange-100'],
                ['route'=>'admin.classes.index',    'icon'=>'fa-chalkboard-teacher',    'label'=>'Classes',     'color'=>'bg-cyan-50 text-cyan-600 border-cyan-100'],
            ];
        @endphp
        @foreach($modules as $m)
            <a href="{{ route($m['route']) }}" class="bg-white rounded-xl border {{ explode(' ', $m['color'])[2] }} p-4 flex flex-col items-center gap-2 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 group">
                <div class="w-10 h-10 rounded-xl {{ $m['color'] }} flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $m['icon'] }}"></i>
                </div>
                <span class="text-xs font-semibold text-slate-700">{{ $m['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

{{-- Chart.js Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Revenue Trend Line Chart ──────────────────────────────
    const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
    if (revenueCtx) {
        const gradient = revenueCtx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(99,102,241,0.25)');
        gradient.addColorStop(1, 'rgba(99,102,241,0)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [{
                    label: 'Revenue (PKR)',
                    data: @json($trendData),
                    borderColor: '#6366f1',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#6366f1',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' PKR ' + ctx.raw.toLocaleString()
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 }, color: '#94a3b8', callback: v => 'PKR ' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) } }
                }
            }
        });
    }

    // ── Order Status Doughnut Chart ───────────────────────────
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        const statusData = {
            pending_payment: {{ $orderStatusCounts['pending_payment'] ?? 0 }},
            processing:      {{ $orderStatusCounts['processing'] ?? 0 }},
            shipped:         {{ $orderStatusCounts['shipped'] ?? 0 }},
            delivered:       {{ $orderStatusCounts['delivered'] ?? 0 }},
            cancelled:       {{ $orderStatusCounts['cancelled'] ?? 0 }},
        };
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: ['#facc15','#60a5fa','#818cf8','#34d399','#f87171'],
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.label + ': ' + ctx.raw
                        }
                    }
                }
            }
        });
    }

});
</script>

@endsection
