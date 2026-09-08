@extends('layouts.base')

@section('title', 'Sign In - MilkFlow Dairy SaaS')

@section('layout_content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-brand-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center relative z-10">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center text-slate-950 shadow-lg shadow-brand-500/30">
                <i data-lucide="milk" class="w-7 h-7"></i>
            </div>
            <div class="text-left">
                <span class="text-2xl font-black text-white tracking-tight">Milk<span class="text-brand-400">Flow</span></span>
                <span class="block text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Dairy Management SaaS</span>
            </div>
        </a>
        <h2 class="mt-6 text-2xl font-extrabold text-white tracking-tight">Sign in to your portal</h2>
        <p class="mt-1 text-xs text-slate-400">Manage your dairy shop, customer milk, billing and deliveries.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10 px-4">
        <!-- Showcase Fast Access Box -->
        <div class="mb-6 p-4 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md shadow-xl text-white">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2 h-2 rounded-full bg-brand-400 animate-ping"></span>
                <span class="text-[11px] font-bold text-brand-300 uppercase tracking-wider">Instant Demo Showcase Logins</span>
            </div>
            <p class="text-[11px] text-slate-300 mb-3">Click any button below to instantly sign in with full pre-loaded sample data:</p>
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('demo.switch', 'super_admin') }}" class="p-2.5 rounded-xl bg-indigo-600/80 hover:bg-indigo-600 text-center transition border border-indigo-400/30 group">
                    <i data-lucide="shield-check" class="w-4 h-4 mx-auto mb-1 text-indigo-200"></i>
                    <span class="block text-[10px] font-bold">Super Admin</span>
                    <span class="text-[9px] text-indigo-200 block truncate">Platform Owner</span>
                </a>
                <a href="{{ route('demo.switch', 'dairy_admin') }}" class="p-2.5 rounded-xl bg-brand-600/80 hover:bg-brand-600 text-center transition border border-brand-400/30 group">
                    <i data-lucide="store" class="w-4 h-4 mx-auto mb-1 text-brand-200"></i>
                    <span class="block text-[10px] font-bold">Dairy Admin</span>
                    <span class="text-[9px] text-brand-200 block truncate">Shree Krishna</span>
                </a>
                <a href="{{ route('demo.switch', 'customer') }}" class="p-2.5 rounded-xl bg-amber-600/80 hover:bg-amber-600 text-center transition border border-amber-400/30 group">
                    <i data-lucide="smartphone" class="w-4 h-4 mx-auto mb-1 text-amber-200"></i>
                    <span class="block text-[10px] font-bold">Customer</span>
                    <span class="text-[9px] text-amber-200 block truncate">Rajesh Sharma</span>
                </a>
            </div>
        </div>

        <!-- Standard Login Card -->
        <div class="bg-white py-8 px-6 shadow-2xl rounded-3xl sm:px-10 border border-slate-200/80">
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile Number or Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="login" value="{{ old('login', 'dairy@milkflow.demo') }}" required 
                               class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                        <span class="text-xs text-brand-600">Default: password</span>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input type="password" name="password" value="password" required 
                               class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-slate-50/50">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center text-xs text-slate-600">
                        <input type="checkbox" name="remember" checked class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                        Remember session
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-md shadow-brand-600/20 transition flex items-center justify-center gap-2">
                    <span>Sign In to Dashboard</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    New Dairy Shop owner? 
                    <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-700">
                        Register Your Dairy Now &rarr;
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
