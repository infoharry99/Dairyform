@extends('layouts.base')

@section('layout_content')
<div class="min-h-screen bg-slate-100 flex flex-col items-center justify-start pb-20 sm:pb-8">
    <!-- Centered Mobile-App Shell (Looks like a sleek native app on desktop, native full-bleed on mobile) -->
    <div class="w-full sm:max-w-md bg-white min-h-screen sm:min-h-[92vh] sm:my-4 sm:rounded-[36px] sm:shadow-2xl border border-slate-200/90 flex flex-col overflow-hidden relative">
        <!-- App Top Header -->
        <header class="bg-gradient-to-r from-slate-900 via-brand-950 to-slate-900 text-white p-5 sticky top-9 z-20 shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white shadow-md shadow-brand-500/30">
                        <i data-lucide="milk" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-xs text-brand-300 font-semibold uppercase tracking-wider block">My Milk App</span>
                        <h2 class="text-base font-extrabold tracking-tight">{{ $customer->dairy->name ?? 'Shree Krishna Dairy' }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('customer.support') }}" class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition" title="Helpdesk">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('logout') }}" title="Log Out" class="p-2 rounded-xl bg-white/10 hover:bg-rose-500/40 text-white transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </header>

        <!-- Customer View Content -->
        <main class="flex-1 p-5 overflow-y-auto custom-scrollbar space-y-5 bg-slate-50/60">
            @yield('content')
        </main>

        <!-- Mobile App Bottom Navigation Bar -->
        <nav class="fixed sm:absolute bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200/80 px-4 py-2 flex items-center justify-around text-[10px] font-bold z-30 shadow-lg">
            <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition {{ request()->routeIs('customer.dashboard') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span>Today</span>
            </a>

            <a href="{{ route('customer.milk') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition {{ request()->routeIs('customer.milk') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="calendar" class="w-5 h-5"></i>
                <span>Calendar</span>
            </a>

            <a href="{{ route('customer.bills') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition {{ request()->routeIs('customer.bills') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="receipt" class="w-5 h-5"></i>
                <span>Bills</span>
            </a>

            <a href="{{ route('customer.payments') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition {{ request()->routeIs('customer.payments') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                <span>Pay Online</span>
            </a>

            <a href="{{ route('customer.profile') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition {{ request()->routeIs('customer.profile') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span>Profile</span>
            </a>
        </nav>
    </div>
</div>
@endsection
