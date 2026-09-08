@extends('layouts.base')

@section('layout_content')
<div class="min-h-screen flex bg-slate-100/70" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Backdrop -->
    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 border-r border-slate-800 shadow-xl">
        <!-- Brand Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/50">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white shadow-md shadow-brand-500/20">
                    <i data-lucide="milk" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-xl font-extrabold text-white tracking-tight">Milk<span class="text-brand-400">Flow</span></span>
                    <span class="block text-[9px] uppercase font-bold tracking-widest text-slate-400">
                        @if(Auth::check() && Auth::user()->isSuperAdmin())
                            Platform Admin
                        @else
                            Dairy Tenant
                        @endif
                    </span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Tenant / Context Badge -->
        @if(Auth::check() && !Auth::user()->isSuperAdmin())
        <div class="p-3 mx-3 mt-3 rounded-xl bg-slate-800/60 border border-slate-700/50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold text-xs">
                SK
            </div>
            <div class="overflow-hidden">
                <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->dairy->name ?? 'Shree Krishna Dairy' }}</span>
                <span class="text-[10px] text-emerald-400 flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Standard Plan (Active)
                </span>
            </div>
        </div>
        @endif

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar text-xs font-semibold">
            @if(Auth::check() && Auth::user()->isSuperAdmin())
                <!-- SUPER ADMIN MENU -->
                <div class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Governance</div>
                
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('superadmin.dairies') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.dairies*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="store" class="w-4 h-4"></i>
                    <span>Dairy Shops</span>
                </a>

                <a href="{{ route('superadmin.subscriptions') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.subscriptions*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Subscriptions</span>
                </a>

                <a href="{{ route('superadmin.payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.payments*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    <span>Payments & Approvals</span>
                </a>

                <a href="{{ route('superadmin.customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.customers*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>All Customers</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Intelligence & Support</div>

                <a href="{{ route('superadmin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.reports*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    <span>Reports & Analytics</span>
                </a>

                <a href="{{ route('superadmin.notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.notifications*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    <span>Notifications</span>
                </a>

                <a href="{{ route('superadmin.support') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.support*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="life-buoy" class="w-4 h-4"></i>
                    <span>Support Desk</span>
                </a>

                <a href="{{ route('superadmin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('superadmin.settings*') ? 'bg-indigo-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Platform Settings</span>
                </a>

            @else
                <!-- DAIRY ADMIN MENU -->
                <div class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Operations</div>

                <a href="{{ route('dairy.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.dashboard') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('dairy.customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.customers*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Customers</span>
                </a>

                <a href="{{ route('dairy.milk') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.milk*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="milk" class="w-4 h-4"></i>
                    <span>Milk Management</span>
                </a>

                <a href="{{ route('dairy.delivery') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.delivery*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="truck" class="w-4 h-4"></i>
                    <span>Daily Delivery</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Finance & Commerce</div>

                <a href="{{ route('dairy.billing') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.billing*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="receipt" class="w-4 h-4"></i>
                    <span>Billing & Invoices</span>
                </a>

                <a href="{{ route('dairy.payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.payments*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span>Payments & Ledger</span>
                </a>

                <a href="{{ route('dairy.products') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.products*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span>Products (Ghee/Paneer)</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Management</div>

                <a href="{{ route('dairy.staff') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.staff*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span>Staff & Routes</span>
                </a>

                <a href="{{ route('dairy.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.reports*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    <span>Reports & Analytics</span>
                </a>

                <a href="{{ route('dairy.notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.notifications*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    <span>Notifications</span>
                </a>

                <a href="{{ route('dairy.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dairy.settings*') ? 'bg-brand-600 text-white font-bold shadow' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    <span>Shop Settings</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-200 flex items-center justify-center font-bold text-xs">
                        {{ substr(Auth::user()->name ?? 'User', 0, 1) }}
                    </div>
                    <div class="truncate">
                        <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->name ?? 'Demo User' }}</span>
                        <span class="text-[10px] text-slate-400 block truncate">{{ Auth::user()->email ?? 'demo@milkflow.in' }}</span>
                    </div>
                </div>
                <a href="{{ route('logout') }}" title="Log Out" class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Navigation Header -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-9 z-20 shadow-xs">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900 truncate">@yield('page_title', 'Dashboard')</h2>
                    @yield('header_badge')
                </div>
            </div>

            <!-- Header Right Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-brand-600 px-2.5 py-1.5 rounded-lg hover:bg-slate-50 transition">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Public Website</span>
                </a>

                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                <!-- Notifications Pill -->
                <div class="relative">
                    <button class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition relative">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                        <span class="w-2 h-2 rounded-full bg-rose-500 absolute top-1.5 right-1.5"></span>
                    </button>
                </div>

                <!-- Quick Switcher Pill -->
                @if(Auth::check() && !Auth::user()->isSuperAdmin())
                <a href="{{ route('demo.switch', 'customer') }}" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200 transition">
                    <i data-lucide="smartphone" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>Open Customer App</span>
                </a>
                @endif
            </div>
        </header>

        <!-- Page Main View Body -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">
            @yield('content')
        </main>
    </div>
</div>
@endsection
