@extends('layouts.public')

@section('title', 'How It Works - MilkFlow Dairy SaaS')

@section('content')
<div class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Workflow</span>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mt-2">How MilkFlow Modernizes Your Dairy</h1>
        <p class="text-base text-slate-600 mt-4">A simple, bulletproof 6-step system designed for dairy owners with zero technical background.</p>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Step 1 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">1</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 1: Register Your Dairy Online</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Sign up with your dairy name, owner mobile number, address, and city (Indore, Bhopal, Ujjain, Dewas, Rau, etc.). You immediately receive your isolated tenant database with secure credentials.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">2</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 2: Choose a Subscription Plan</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Select Basic (₹499/mo for up to 100 customers), Standard (₹999/mo for up to 500 customers with WhatsApp and UPI), or Premium (₹1,999/mo for unlimited customers with multi-route delivery boy app).
                </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">3</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 3: Add Your Customers & Routes</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Enter customer names, mobile numbers, daily milk quantities (e.g. 2L Cow Milk @ ₹60/L), delivery shift (morning/evening), and street routes (e.g. Scheme 54 or Vijay Nagar).
                </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">4</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 4: Record Daily Milk Deliveries</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Each morning and evening, either the shop owner or delivery boy marks customer entries with 1 tap. If someone took 3 Litres instead of 2 Litres, modify it instantly on your mobile screen.
                </p>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">5</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 5: Generate Month-End Bills Automatically</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    On the 1st of every month, click "Generate Bills". MilkFlow calculates exact litres delivered for every customer, factors in extra curd or ghee purchased, and creates detailed itemized statements.
                </p>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="flex items-start gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-md shadow-brand-600/20">6</div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Step 6: Collect Payments via UPI, QR, or Cash</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Customers pay online via GPay/PhonePe or pay cash at the counter. The payment ledger syncs automatically, balances are adjusted, and WhatsApp receipts are sent instantly.
                </p>
            </div>
        </div>

        <div class="text-center pt-8">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl transition">
                <span>Start Your Dairy Setup Now</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>
</div>
@endsection
