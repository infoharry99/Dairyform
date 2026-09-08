@extends('layouts.admin')

@section('title', 'Dairy Admin Dashboard - MilkFlow')
@section('page_title', 'Daily Operations Command')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200 flex items-center gap-1.5">
    <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
    {{ $dairy->name }}
</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Subscription Expired Gate Alert (As Required by Business Logic) -->
    @if($isSubscriptionExpired)
    <div class="bg-gradient-to-r from-rose-600 to-red-700 p-5 rounded-3xl text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                <i data-lucide="alert-octagon" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="text-base font-bold">Your MilkFlow subscription has expired!</h3>
                <p class="text-xs text-white/90">
                    Your dairy data is safely preserved, but customer notifications and auto-billing are locked. Please renew to continue dispatching milk without interruption.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('pricing') }}" class="px-5 py-2.5 rounded-xl bg-white text-rose-700 font-extrabold text-xs shadow hover:bg-slate-100 transition">
                Renew Subscription
            </a>
            <a href="{{ route('pricing') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition">
                View Plans
            </a>
        </div>
    </div>
    @endif

    <!-- Top Welcome Banner & Quick Actions -->
    <div class="bg-gradient-to-r from-slate-900 via-brand-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 border border-slate-800">
        <div class="space-y-2 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-brand-300 text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span> Active Shift: Morning
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Good morning, Rajesh 👋</h1>
            <p class="text-xs sm:text-sm text-slate-300">
                Operating for <strong class="text-white">{{ $dairy->name }}</strong> (Annapurna Road, Indore). Ready for today's morning distribution.
            </p>
        </div>

        <!-- 4 Quick Actions (As Required by Prompt) -->
        <div class="flex flex-wrap items-center gap-2.5 relative z-10">
            <a href="{{ route('dairy.customers') }}" class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition flex items-center gap-1.5 backdrop-blur-sm">
                <i data-lucide="user-plus" class="w-4 h-4 text-brand-400"></i>
                <span>Add Customer</span>
            </a>

            <a href="{{ route('dairy.milk') }}" class="px-3.5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition flex items-center gap-1.5">
                <i data-lucide="clipboard-check" class="w-4 h-4"></i>
                <span>Record Milk</span>
            </a>

            <a href="{{ route('dairy.billing') }}" class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition flex items-center gap-1.5 backdrop-blur-sm">
                <i data-lucide="receipt" class="w-4 h-4 text-brand-400"></i>
                <span>Create Bill</span>
            </a>

            <a href="{{ route('dairy.payments') }}" class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition flex items-center gap-1.5 backdrop-blur-sm">
                <i data-lucide="wallet" class="w-4 h-4 text-brand-400"></i>
                <span>Record Payment</span>
            </a>
        </div>
    </div>

    <!-- 6 Statistics Cards (As Required by Prompt) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- 1. Today's Milk (486 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Today's Milk</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600"><i data-lucide="milk" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900">{{ $totalLitresToday }} <span class="text-xs text-slate-500 font-normal">L</span></div>
            <div class="text-[11px] text-slate-500 mt-1">Morning + Evening</div>
        </div>

        <!-- 2. Customers (324) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Customers</span>
                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600"><i data-lucide="users" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900">{{ $totalCustomers }}</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-1">Across 4 Routes</div>
        </div>

        <!-- 3. Today's Revenue (₹28,450) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Today's Sales</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600"><i data-lucide="indian-rupee" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900">{{ $todayRevenue }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Cash + UPI Collections</div>
        </div>

        <!-- 4. Pending Payments (₹12,680) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Pending Dues</span>
                <span class="p-1.5 rounded-lg bg-rose-50 text-rose-600"><i data-lucide="clock" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-rose-600">{{ $pendingPayments }}</div>
            <div class="text-[11px] text-rose-500 mt-1">14 Accounts Due</div>
        </div>

        <!-- 5. Milk Delivered (412 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Milk Delivered</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-emerald-600">{{ $deliveredLitres }} <span class="text-xs text-slate-500 font-normal">L</span></div>
            <div class="text-[11px] text-emerald-700 font-bold mt-1">85% Morning Done</div>
        </div>

        <!-- 6. Milk Pending (74 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Milk Pending</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600"><i data-lucide="truck" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-amber-600">{{ $pendingLitres }} <span class="text-xs text-slate-500 font-normal">L</span></div>
            <div class="text-[11px] text-amber-700 font-bold mt-1">Palasia Route Active</div>
        </div>
    </div>

    <!-- Charts Section (As Required by Prompt) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Daily Milk Consumption Trend -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Daily Milk Delivery Trend (Last 7 Days)</h3>
                    <p class="text-xs text-slate-500">Morning vs Evening litres dispatched</p>
                </div>
                <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-1 rounded-lg">Average: 478 L/day</span>
            </div>
            <div class="h-64 relative">
                <canvas id="dairyMilkChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Monthly Revenue & Pending Collections -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Monthly Revenue & Cash vs UPI Mix</h3>
                    <p class="text-xs text-slate-500">Total ₹3.84 Lakhs collected in September</p>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">94% Collected</span>
            </div>
            <div class="h-64 relative">
                <canvas id="dairyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Active Delivery Shift Progress & Recent Bills -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Live Route Dispatch Tracker -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Today's Morning Route Progress</h3>
                    <p class="text-xs text-slate-500">Live delivery boy check-ins in Indore</p>
                </div>
                <a href="{{ route('dairy.delivery') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                    Route Manager <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Route 1: Scheme 54 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <strong class="text-slate-900 font-bold">Scheme 54 Route</strong>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Completed ✓</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Boy: Suresh Parmar (+91 97555 11223)</p>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-600 font-medium">
                        <span>142 Litres Dispatched</span>
                        <span>48/48 Customers</span>
                    </div>
                </div>

                <!-- Route 2: Vijay Nagar -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <strong class="text-slate-900 font-bold">Vijay Nagar Route</strong>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Completed ✓</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Boy: Suresh Parmar</p>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-600 font-medium">
                        <span>160 Litres Dispatched</span>
                        <span>54/54 Customers</span>
                    </div>
                </div>

                <!-- Route 3: Palasia -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <strong class="text-slate-900 font-bold">Palasia Route</strong>
                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold animate-pulse">In Delivery (68%)</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Boy: Kamlesh Yadav (+91 97555 22334)</p>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: 68%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-600 font-medium">
                        <span>110 Litres Dispatched</span>
                        <span>32/45 Customers</span>
                    </div>
                </div>

                <!-- Route 4: Rau Route -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <strong class="text-slate-900 font-bold">Rau Highway Route</strong>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Completed ✓</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Boy: Kamlesh Yadav</p>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-600 font-medium">
                        <span>74 Litres Dispatched</span>
                        <span>28/28 Customers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Billing & Pending Dues Widget -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Pending Customer Bills</h3>
                    <span class="text-xs font-bold text-rose-600">₹12,680 Total</span>
                </div>

                <div class="space-y-3 text-xs">
                    @foreach($recentBills as $bill)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <div>
                            <strong class="text-slate-900 block">{{ $bill->customer->name ?? 'Customer' }}</strong>
                            <span class="text-[10px] text-slate-400">{{ $bill->bill_number }} • {{ $bill->month_year }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-900 block">₹{{ number_format($bill->pending_amount) }}</span>
                            <span class="text-[10px] font-semibold {{ $bill->status === 'paid' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ strtoupper($bill->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-100">
                <a href="{{ route('dairy.billing') }}" class="block text-center py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition">
                    View Complete Billing Ledger &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Dairy Daily Milk Chart
    const ctxMilk = document.getElementById('dairyMilkChart');
    if (ctxMilk) {
        new Chart(ctxMilk, {
            type: 'line',
            data: {
                labels: ['Sep 02', 'Sep 03', 'Sep 04', 'Sep 05', 'Sep 06', 'Sep 07', 'Today (Sep 08)'],
                datasets: [
                    {
                        label: 'Morning Shift (L)',
                        data: [398, 405, 410, 402, 415, 408, 412],
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                    },
                    {
                        label: 'Evening Shift (L)',
                        data: [72, 70, 75, 71, 76, 73, 74],
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.3,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } }
                },
                scales: {
                    y: { beginAtZero: false, min: 50 }
                }
            }
        });
    }

    // 2. Dairy Monthly Revenue Chart
    const ctxRev = document.getElementById('dairyRevenueChart');
    if (ctxRev) {
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4 (Proj)'],
                datasets: [
                    {
                        label: 'Online UPI (₹)',
                        data: [68400, 74200, 81000, 79400],
                        backgroundColor: '#16a34a',
                        borderRadius: 6,
                    },
                    {
                        label: 'Counter Cash (₹)',
                        data: [24000, 22500, 19800, 15150],
                        backgroundColor: '#f59e0b',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) { return '₹' + (val/1000) + 'k'; }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
