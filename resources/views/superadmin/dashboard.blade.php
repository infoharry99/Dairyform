@extends('layouts.admin')

@section('title', 'Super Admin Dashboard - MilkFlow Platform')
@section('page_title', 'Platform Executive Overview')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
    Multi-Tenant Control Plane
</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Top Welcome Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border border-slate-800">
        <div class="space-y-2 relative z-10">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-brand-300 text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Platform Master Node
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Good morning, Admin 👋</h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                MilkFlow network is operating at 99.9% uptime. <strong>1,086 active dairy shops</strong> are currently dispatching morning milk deliveries across Central India.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('superadmin.dairies') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg transition flex items-center gap-2">
                <i data-lucide="store" class="w-4 h-4"></i>
                <span>Manage Dairies</span>
            </a>
            <a href="{{ route('superadmin.payments') }}" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-bold text-xs border border-white/20 transition flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>70 Approvals Pending</span>
            </a>
        </div>
    </div>

    <!-- KPI Metrics Grid (As Required by Prompt) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Total Dairies -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Total Dairies</span>
                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600"><i data-lucide="store" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_dairies']) }}</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                <i data-lucide="trending-up" class="w-3 h-3"></i> +32 this month
            </div>
        </div>

        <!-- Active Dairies -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Active Dairies</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600"><i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-emerald-600">{{ number_format($stats['active_dairies']) }}</div>
            <div class="text-[11px] text-slate-500 mt-1">87% Active Ratio</div>
        </div>

        <!-- Expired Subscriptions -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Expired Subs</span>
                <span class="p-1.5 rounded-lg bg-rose-50 text-rose-600"><i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-rose-600">{{ $stats['expired_subscriptions'] }}</div>
            <div class="text-[11px] text-rose-500 mt-1">Renewals needed</div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Pending Approvals</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600"><i data-lucide="clock" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-amber-600">{{ $stats['pending_approvals'] }}</div>
            <div class="text-[11px] text-amber-600 mt-1">New registrations</div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Monthly Revenue</span>
                <span class="p-1.5 rounded-lg bg-indigo-50 text-indigo-600"><i data-lucide="indian-rupee" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-indigo-700">{{ $stats['monthly_revenue'] }}</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-1">+14.2% MoM</div>
        </div>

        <!-- Yearly Revenue -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                <span>Yearly Run-Rate</span>
                <span class="p-1.5 rounded-lg bg-purple-50 text-purple-600"><i data-lucide="bar-chart-3" class="w-3.5 h-3.5"></i></span>
            </div>
            <div class="text-2xl font-extrabold text-purple-700">{{ $stats['yearly_revenue'] }}</div>
            <div class="text-[11px] text-slate-500 mt-1">ARR Target: ₹2Cr</div>
        </div>
    </div>

    <!-- Super Admin Charts (2-Column Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Revenue Overview & Subscription Growth -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Platform Revenue Overview (₹ Lakhs)</h3>
                    <p class="text-xs text-slate-500">Monthly recurring subscription billing for 2026</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">FY 2026-27</span>
            </div>
            <div class="h-64 relative">
                <canvas id="superAdminRevenueChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Active vs Expired Subscriptions & New Dairy Registrations -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Dairy Subscriptions & Status Distribution</h3>
                    <p class="text-xs text-slate-500">Active (1,086) vs Expired (92) vs Pending (70)</p>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">Healthy</span>
            </div>
            <div class="h-64 relative flex items-center justify-center">
                <canvas id="superAdminStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Dairies & Platform Activity Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Registered Dairies Quick View -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Registered Dairy Shops</h3>
                    <p class="text-xs text-slate-500">Recently onboarded tenants across MP</p>
                </div>
                <a href="{{ route('superadmin.dairies') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                    View All 1,248 Dairies <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-100 font-bold uppercase tracking-wider">
                            <th class="pb-3">Dairy Shop</th>
                            <th class="pb-3">Owner / Contact</th>
                            <th class="pb-3">City</th>
                            <th class="pb-3">Plan</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($dairies->take(5) as $d)
                        <tr>
                            <td class="py-3">
                                <div class="font-bold text-slate-900">{{ $d->name }}</div>
                                <div class="text-[10px] text-slate-400">ID: MF-{{ $d->id }} • {{ $d->customers->count() ?? 324 }} customers</div>
                            </td>
                            <td class="py-3">
                                <div class="text-slate-800">{{ $d->owner_name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $d->phone }}</div>
                            </td>
                            <td class="py-3 text-slate-700 font-semibold">{{ $d->city }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full font-bold text-[10px] bg-slate-100 text-slate-700">
                                    {{ $d->activeSubscription->plan->name ?? 'Standard' }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if($d->status === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @elseif($d->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @elseif($d->status === 'expired')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                        {{ ucfirst($d->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('superadmin.dairies') }}?search={{ urlencode($d->name) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                    Manage
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity Feed (As Required by Prompt) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Recent Platform Activity</h3>
                    <span class="text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live
                    </span>
                </div>

                <div class="space-y-4">
                    @foreach($activities as $act)
                    <div class="flex items-start gap-3 text-xs">
                        <div class="mt-0.5 w-6 h-6 rounded-full flex items-center justify-center shrink-0 
                            {{ $act['type'] === 'success' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $act['type'] === 'info' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $act['type'] === 'warning' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $act['type'] === 'alert' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $act['type'] === 'danger' ? 'bg-rose-100 text-rose-700' : '' }}">
                            <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-slate-900 leading-snug">{{ $act['title'] }}</div>
                            <span class="text-[10px] text-slate-400">{{ $act['time'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-100">
                <a href="{{ route('superadmin.payments') }}" class="block text-center py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                    Review Pending Approvals
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Super Admin Revenue Line/Bar Chart
    const ctxRevenue = document.getElementById('superAdminRevenueChart');
    if (ctxRevenue) {
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep (Proj)'],
                datasets: [{
                    label: 'Monthly Platform Subscriptions (₹ Lakhs)',
                    data: [7.8, 8.9, 9.6, 11.2, 11.8, 12.48],
                    backgroundColor: '#4f46e5',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) { return '₹' + val + 'L'; }
                        }
                    }
                }
            }
        });
    }

    // 2. Status Doughnut Chart
    const ctxStatus = document.getElementById('superAdminStatusChart');
    if (ctxStatus) {
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Active Subscriptions (1,086)', 'Expired (92)', 'Pending Verification (70)'],
                datasets: [{
                    data: [1086, 92, 70],
                    backgroundColor: ['#10b981', '#f43f5e', '#f59e0b'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                },
                cutout: '70%'
            }
        });
    }
});
</script>
@endpush
