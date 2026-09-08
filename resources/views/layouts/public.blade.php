@extends('layouts.base')

@section('layout_content')
<div class="min-h-screen flex flex-col bg-white">
    <!-- Navigation Header -->
    <header class="sticky top-9 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white shadow-md shadow-brand-500/20 group-hover:scale-105 transition">
                        <i data-lucide="milk" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-2xl font-extrabold text-slate-900 tracking-tight">Milk<span class="text-brand-600">Flow</span></span>
                            <span class="text-[10px] uppercase font-bold tracking-wider px-1.5 py-0.5 rounded bg-brand-50 text-brand-700 border border-brand-200/60">SaaS</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium hidden sm:block">Smart Dairy Management for Every Dairy</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-brand-600 transition {{ request()->routeIs('home') ? 'text-brand-600 font-semibold' : '' }}">Home</a>
                    <a href="{{ route('features') }}" class="hover:text-brand-600 transition {{ request()->routeIs('features') ? 'text-brand-600 font-semibold' : '' }}">Features</a>
                    <a href="{{ route('how-it-works') }}" class="hover:text-brand-600 transition {{ request()->routeIs('how-it-works') ? 'text-brand-600 font-semibold' : '' }}">How It Works</a>
                    <a href="{{ route('pricing') }}" class="hover:text-brand-600 transition {{ request()->routeIs('pricing') ? 'text-brand-600 font-semibold' : '' }}">Pricing</a>
                    <a href="{{ route('about') }}" class="hover:text-brand-600 transition {{ request()->routeIs('about') ? 'text-brand-600 font-semibold' : '' }}">About</a>
                    <a href="{{ route('contact') }}" class="hover:text-brand-600 transition {{ request()->routeIs('contact') ? 'text-brand-600 font-semibold' : '' }}">Contact</a>
                </nav>

                <!-- Auth / Action Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-brand-700 px-3.5 py-2 rounded-xl hover:bg-slate-100 transition flex items-center gap-1.5">
                        <i data-lucide="log-in" class="w-4 h-4 text-slate-400"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-md shadow-brand-600/20 hover:shadow-lg hover:shadow-brand-600/30 transition">
                        <span>Start Your Dairy</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800/80">
                <!-- Brand Info -->
                <div class="md:col-span-1 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white">
                            <i data-lucide="milk" class="w-5 h-5"></i>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">Milk<span class="text-brand-400">Flow</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        The all-in-one multi-tenant Dairy Management Operating System empowering local milk shops, farm unions, and urban milk delivery businesses across India.
                    </p>
                    <div class="flex items-center gap-3 text-slate-400">
                        <span class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white transition"><i data-lucide="phone" class="w-4 h-4"></i></span>
                        <span class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white transition"><i data-lucide="mail" class="w-4 h-4"></i></span>
                        <span class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white transition"><i data-lucide="map-pin" class="w-4 h-4"></i></span>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Platform</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('features') }}" class="hover:text-brand-400 transition">Customer Management</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-brand-400 transition">Morning / Evening Milk</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-brand-400 transition">Route & Delivery Boy App</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-brand-400 transition">Automated WhatsApp Bills</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-brand-400 transition">Subscription Plans</a></li>
                    </ul>
                </div>

                <!-- Cities Served -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Active Hubs</h4>
                    <ul class="space-y-2 text-xs">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span> Indore (Scheme 54, Vijay Nagar, Palasia)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span> Bhopal (Arera Colony, MP Nagar)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span> Ujjain (Freeganj, Mahakal Marg)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span> Dewas & Rau Milk Hubs</li>
                    </ul>
                </div>

                <!-- Showcase Demo CTA -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-5 rounded-2xl border border-slate-800 space-y-3">
                    <span class="text-[11px] font-bold text-brand-400 uppercase tracking-wider">Showcase Ready</span>
                    <h5 class="text-sm font-bold text-white">Experience MilkFlow Today</h5>
                    <p class="text-xs text-slate-400">Explore all portals with one click using our demo switcher.</p>
                    <a href="{{ route('demo.switch', 'dairy_admin') }}" class="block text-center py-2 px-3 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-semibold text-xs transition shadow">
                        Launch Live Dairy Demo
                    </a>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; 2026 MilkFlow Technologies Pvt. Ltd. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-300">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-300">Terms of Service</a>
                    <a href="#" class="hover:text-slate-300">Security & Compliance</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
