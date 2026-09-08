@extends('layouts.public')

@section('title', 'MilkFlow - Smart Dairy Management for Every Dairy | SaaS Platform')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden pt-12 pb-24 lg:pt-20 bg-gradient-to-b from-brand-50/40 via-white to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-6">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-100/70 text-brand-800 text-xs font-bold tracking-wide uppercase border border-brand-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Next-Gen Multi-Tenant Dairy SaaS
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                Manage Your Dairy. <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-emerald-600 to-teal-700">
                    Grow Your Business.
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto font-normal">
                MilkFlow helps dairy shops manage customers, milk deliveries, billing, payments and daily operations from one simple platform.
            </p>

            <!-- Action CTAs -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl shadow-brand-600/25 hover:shadow-2xl hover:shadow-brand-600/35 transition flex items-center justify-center gap-2.5">
                    <span>Start Your Dairy</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('demo.switch', 'dairy_admin') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-base border border-slate-200 shadow-sm hover:shadow transition flex items-center justify-center gap-2.5">
                    <i data-lucide="play" class="w-5 h-5 text-brand-600 fill-brand-600"></i>
                    <span>View Demo</span>
                </a>
            </div>

            <!-- Trust Micro-Proof -->
            <div class="flex items-center justify-center gap-6 pt-4 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-4 h-4 text-brand-600"></i> 14-Day Free Demo</span>
                <span class="flex items-center gap-1.5"><i data-lucide="smartphone" class="w-4 h-4 text-brand-600"></i> WhatsApp Integrated</span>
                <span class="flex items-center gap-1.5"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Zero Hardware Setup</span>
            </div>
        </div>

        <!-- Realistic SaaS Dashboard Preview Hero Visual -->
        <div class="mt-14 relative max-w-5xl mx-auto">
            <div class="rounded-3xl p-3 sm:p-4 bg-gradient-to-b from-slate-200/70 to-slate-100 shadow-2xl border border-slate-200/80">
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-inner">
                    <!-- Preview Browser / App Header -->
                    <div class="bg-slate-900 px-4 py-3 flex items-center justify-between text-white text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                            <span class="text-slate-400 font-mono text-[11px] ml-2 hidden sm:inline">app.milkflow.in/dairy/dashboard</span>
                        </div>
                        <div class="flex items-center gap-3 font-medium">
                            <span class="text-emerald-400 flex items-center gap-1"><i data-lucide="wifi" class="w-3.5 h-3.5"></i> Live Dairy Sync</span>
                            <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Shree Krishna Dairy</span>
                        </div>
                    </div>

                    <!-- Live Dashboard Preview Content -->
                    <div class="p-4 sm:p-6 bg-slate-50/70 space-y-6">
                        <!-- Top KPI Row -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                            <!-- Today's Milk -->
                            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
                                <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                                    <span>Today's Milk</span>
                                    <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600"><i data-lucide="milk" class="w-4 h-4"></i></span>
                                </div>
                                <div class="text-2xl font-extrabold text-slate-900">486 <span class="text-xs text-slate-500 font-normal">Litres</span></div>
                                <div class="mt-2 flex items-center justify-between text-[11px]">
                                    <span class="text-emerald-700 font-bold">412 L Delivered</span>
                                    <span class="text-amber-700 font-bold">74 L Pending</span>
                                </div>
                            </div>

                            <!-- Total Customers -->
                            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
                                <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                                    <span>Total Customers</span>
                                    <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600"><i data-lucide="users" class="w-4 h-4"></i></span>
                                </div>
                                <div class="text-2xl font-extrabold text-slate-900">324</div>
                                <div class="mt-2 text-[11px] text-emerald-600 font-medium flex items-center gap-1">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> +18 new this month
                                </div>
                            </div>

                            <!-- Monthly Sales -->
                            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
                                <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                                    <span>Today's Revenue</span>
                                    <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600"><i data-lucide="indian-rupee" class="w-4 h-4"></i></span>
                                </div>
                                <div class="text-2xl font-extrabold text-slate-900">₹28,450</div>
                                <div class="mt-2 text-[11px] text-slate-500">
                                    Monthly: <strong class="text-slate-800">₹3.84 Lakhs</strong>
                                </div>
                            </div>

                            <!-- Pending Payments -->
                            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
                                <div class="flex items-center justify-between text-slate-500 text-xs font-semibold mb-1">
                                    <span>Pending Payments</span>
                                    <span class="p-1.5 rounded-lg bg-rose-50 text-rose-600"><i data-lucide="clock" class="w-4 h-4"></i></span>
                                </div>
                                <div class="text-2xl font-extrabold text-rose-600">₹12,680</div>
                                <div class="mt-2 text-[11px] text-slate-500">
                                    <span class="text-rose-600 font-semibold">14 customers</span> pending
                                </div>
                            </div>
                        </div>

                        <!-- Split Content: Milk Delivery Table & Recent Transactions -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- Delivery Status Table -->
                            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200/80 shadow-sm p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="truck" class="w-4 h-4 text-brand-600"></i>
                                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Morning Delivery Status (Scheme 54 & Vijay Nagar)</h3>
                                    </div>
                                    <span class="text-[11px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded">Active Shift</span>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs">
                                        <thead>
                                            <tr class="text-slate-400 border-b border-slate-100 font-semibold">
                                                <th class="pb-2">Customer</th>
                                                <th class="pb-2">Quantity</th>
                                                <th class="pb-2">Milk Type</th>
                                                <th class="pb-2">Rate</th>
                                                <th class="pb-2">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                            <tr>
                                                <td class="py-2.5 font-bold text-slate-900">Rajesh Sharma <span class="text-[10px] text-slate-400 block font-normal">Flat 302, Scheme 54</span></td>
                                                <td class="py-2.5 font-bold">2.0 L</td>
                                                <td class="py-2.5"><span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-semibold">Cow Milk</span></td>
                                                <td class="py-2.5 font-semibold">₹60/L</td>
                                                <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]"><i data-lucide="check" class="w-3 h-3"></i> Delivered</span></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2.5 font-bold text-slate-900">Priya Verma <span class="text-[10px] text-slate-400 block font-normal">B-14 Silver Springs, Vijay Nagar</span></td>
                                                <td class="py-2.5 font-bold">1.5 L</td>
                                                <td class="py-2.5"><span class="px-2 py-0.5 rounded bg-purple-50 text-purple-700 text-[10px] font-semibold">Buffalo Milk</span></td>
                                                <td class="py-2.5 font-semibold">₹72/L</td>
                                                <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]"><i data-lucide="check" class="w-3 h-3"></i> Delivered</span></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2.5 font-bold text-slate-900">Alok Nath <span class="text-[10px] text-slate-400 block font-normal">22 Anand Bazaar, Palasia</span></td>
                                                <td class="py-2.5 font-bold">3.0 L</td>
                                                <td class="py-2.5"><span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-semibold">Cow Milk</span></td>
                                                <td class="py-2.5 font-semibold">₹60/L</td>
                                                <td class="py-2.5"><span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-bold text-[10px]"><i data-lucide="clock" class="w-3 h-3"></i> In Transit</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Recent Transactions -->
                            <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm p-4 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Recent Payments</h3>
                                        <span class="text-[11px] text-slate-400">Live Feed</span>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between text-xs p-2 rounded-lg bg-slate-50">
                                            <div>
                                                <div class="font-bold text-slate-900">Rajesh Sharma</div>
                                                <div class="text-[10px] text-slate-500">Google Pay • Sept Bill</div>
                                            </div>
                                            <span class="font-bold text-emerald-600">+₹2,400</span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs p-2 rounded-lg bg-slate-50">
                                            <div>
                                                <div class="font-bold text-slate-900">Alok Nath</div>
                                                <div class="text-[10px] text-slate-500">PhonePe QR • Counter</div>
                                            </div>
                                            <span class="font-bold text-emerald-600">+₹3,600</span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs p-2 rounded-lg bg-slate-50">
                                            <div>
                                                <div class="font-bold text-slate-900">Suresh Parmar (Delivery)</div>
                                                <div class="text-[10px] text-slate-500">Cash Collection</div>
                                            </div>
                                            <span class="font-bold text-emerald-600">+₹2,000</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <span class="text-slate-500 font-medium">WhatsApp Alert Auto-Sent</span>
                                    <span class="text-brand-600 font-bold flex items-center gap-1"><i data-lucide="message-square" class="w-3.5 h-3.5"></i> Connected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section A: Trusted / Platform Statistics -->
<section class="py-16 bg-slate-950 text-white border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-400 tracking-tight">500+</div>
                <div class="text-xs sm:text-sm font-semibold text-slate-300 mt-2 uppercase tracking-wider">Dairy Shops</div>
                <p class="text-[11px] text-slate-500 mt-1">Active across Indore, Bhopal & MP</p>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-400 tracking-tight">25,000+</div>
                <div class="text-xs sm:text-sm font-semibold text-slate-300 mt-2 uppercase tracking-wider">Customers</div>
                <p class="text-[11px] text-slate-500 mt-1">Receiving daily fresh milk</p>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-400 tracking-tight">1M+ Litres</div>
                <div class="text-xs sm:text-sm font-semibold text-slate-300 mt-2 uppercase tracking-wider">Managed Monthly</div>
                <p class="text-[11px] text-slate-500 mt-1">Zero milk quantity disputes</p>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-400 tracking-tight">99.9%</div>
                <div class="text-xs sm:text-sm font-semibold text-slate-300 mt-2 uppercase tracking-wider">Platform Availability</div>
                <p class="text-[11px] text-slate-500 mt-1">High-reliability cloud architecture</p>
            </div>
        </div>
    </div>
</section>

<!-- Section B: Features -->
<section id="features" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Built for Real Dairy Operations</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Everything You Need to Run & Scale Your Dairy
            </h2>
            <p class="text-base text-slate-600">
                Replace messy notebooks, lost milk records, and delayed cash collections with MilkFlow's automated system.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. Customer Management -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Customer Management</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Store complete customer profiles, fixed daily milk quantities (Cow/Buffalo), area routes, and pause delivery requests with one click.
                </p>
            </div>

            <!-- 2. Milk Delivery Tracking -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="sun-medium" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Milk Delivery Tracking</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Dedicated Morning & Evening shift recording. Instantly adjust quantities, mark skipped/paused days, and eliminate delivery disputes.
                </p>
            </div>

            <!-- 3. Automatic Billing -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Automatic Billing</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Calculate monthly bills automatically based on actual litres consumed + extra products (paneer, ghee, curd) minus discounts.
                </p>
            </div>

            <!-- 4. Online Payments -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="qr-code" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Online Payments</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Allow customers to pay via UPI (GPay, PhonePe, Paytm), Net Banking, or record manual Cash collections with instant receipts.
                </p>
            </div>

            <!-- 5. Subscription Management -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="credit-card" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Subscription Management</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tiered plans tailored for village milk centers to large city dairy networks. Transparent renewals and automated quota alerts.
                </p>
            </div>

            <!-- 6. Staff Management -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Staff & Route Management</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Create logins for Delivery Boys, Accountants, and Managers. Assign specific street routes and protect sensitive financial data.
                </p>
            </div>

            <!-- 7. Reports & Analytics -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Reports & Analytics</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Daily milk tally, monthly revenue trends, customer pending dues list, and 1-click export to PDF or Excel spreadsheets.
                </p>
            </div>

            <!-- 8. WhatsApp Notifications -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-brand-500/40 transition group">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-5 group-hover:scale-110 transition">
                    <i data-lucide="message-square" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">WhatsApp Notifications</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Automatically dispatch monthly PDF invoices, delivery status notifications, and gentle payment reminders straight to WhatsApp.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section C: How It Works -->
<section id="how-it-works" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Simple 6-Step Implementation</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                How MilkFlow Transforms Your Dairy
            </h2>
            <p class="text-base text-slate-600">
                Get up and running in under 15 minutes—simple enough for any village or town shop owner.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">01</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">1</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Register Your Dairy</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Provide your dairy name, city, owner contact, and create your secure isolated dairy tenant portal.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">02</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">2</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Choose a Subscription</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Select Basic, Standard, or Premium based on your customer count and feature requirements.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">03</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">3</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Add Customers</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Add customer address, area routes, daily milk preference (Cow/Buffalo), and rate per litre.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">04</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">4</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Manage Daily Milk</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Record morning and evening distribution quickly from mobile or computer. Mark delivered or skipped.
                </p>
            </div>

            <!-- Step 5 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">05</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">5</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Generate Bills</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Generate accurate month-end bills in seconds with clear breakdown of milk litres and value-add products.
                </p>
            </div>

            <!-- Step 6 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 relative">
                <span class="text-5xl font-extrabold text-brand-200/70 absolute top-4 right-5">06</span>
                <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 font-bold text-sm">6</div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Collect Payments</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Collect payments effortlessly via UPI QR scan, customer app, or cash, with automatic ledger reconciliation.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section D: Pricing -->
<section id="pricing" class="py-24 bg-slate-50" x-data="{ cycle: 'monthly' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Transparent SaaS Pricing</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Simple Plans Tailored for Your Dairy Scale
            </h2>
            <p class="text-base text-slate-600">
                Choose the right plan to modernize your daily milk distribution and customer billing.
            </p>

            <!-- Billing Cycle Switcher -->
            <div class="pt-6 flex items-center justify-center">
                <div class="inline-flex items-center p-1.5 rounded-2xl bg-slate-200/80 border border-slate-300/60 text-xs font-bold">
                    <button @click="cycle = 'monthly'" 
                            :class="cycle === 'monthly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 rounded-xl transition">
                        Monthly
                    </button>
                    <button @click="cycle = 'half_yearly'" 
                            :class="cycle === 'half_yearly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 rounded-xl transition flex items-center gap-1">
                        Half-Yearly <span class="text-[10px] text-brand-700 bg-brand-100 px-1.5 py-0.5 rounded-full">Save 10%</span>
                    </button>
                    <button @click="cycle = 'yearly'" 
                            :class="cycle === 'yearly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-2 rounded-xl transition flex items-center gap-1">
                        Yearly <span class="text-[10px] text-brand-700 bg-brand-100 px-1.5 py-0.5 rounded-full">Save 20%</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
            @foreach($plans as $plan)
            <div class="relative rounded-3xl p-8 flex flex-col justify-between transition {{ $plan->is_popular ? 'bg-white border-2 border-brand-500 shadow-2xl scale-105 z-10' : 'bg-white border border-slate-200 shadow-sm' }}">
                @if($plan->is_popular)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-brand-600 text-white text-xs font-extrabold uppercase tracking-wider shadow">
                    Most Popular
                </div>
                @endif

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-slate-900">{{ $plan->name }}</h3>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $plan->is_popular ? 'bg-brand-50 text-brand-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $plan->customer_limit }} Customers
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 min-h-[36px]">{{ $plan->tagline }}</p>

                    <!-- Price Display -->
                    <div class="my-6">
                        <div x-show="cycle === 'monthly'">
                            <span class="text-4xl font-extrabold text-slate-900">₹{{ number_format($plan->price_monthly) }}</span>
                            <span class="text-xs text-slate-500 font-medium">/month</span>
                        </div>
                        <div x-show="cycle === 'half_yearly'" x-cloak>
                            <span class="text-4xl font-extrabold text-slate-900">₹{{ number_format($plan->price_half_yearly) }}</span>
                            <span class="text-xs text-slate-500 font-medium">/6 months</span>
                        </div>
                        <div x-show="cycle === 'yearly'" x-cloak>
                            <span class="text-4xl font-extrabold text-slate-900">₹{{ number_format($plan->price_yearly) }}</span>
                            <span class="text-xs text-slate-500 font-medium">/year</span>
                        </div>
                    </div>

                    <!-- Features List -->
                    <div class="pt-6 border-t border-slate-100 space-y-3">
                        <div class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">Included Features:</div>
                        @foreach($plan->features as $f)
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-brand-600 shrink-0 mt-0.5"></i>
                            <span>{{ $f }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-8 mt-6">
                    <a href="{{ route('register') }}?plan={{ $plan->id }}" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs text-center transition block {{ $plan->is_popular ? 'bg-brand-600 hover:bg-brand-700 text-white shadow-md shadow-brand-600/20' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                        Start with {{ $plan->name }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section E: Final CTA -->
<section class="py-20 bg-gradient-to-br from-slate-950 via-slate-900 to-brand-950 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
        <span class="text-xs font-bold uppercase tracking-widest text-brand-400">Transform Your Dairy Today</span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">
            Ready to simplify your dairy business?
        </h2>
        <p class="text-base text-slate-300 max-w-xl mx-auto">
            Join hundreds of smart dairy owners who have streamlined their milk distribution, saved 10+ hours per week, and eliminated unpaid bill confusion.
        </p>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-brand-500 hover:bg-brand-600 text-slate-950 font-extrabold text-sm shadow-xl transition flex items-center gap-2">
                <span>Start Free Demo</span>
                <i data-lucide="arrow-right" class="w-4 h-4 text-slate-950"></i>
            </a>
            <a href="{{ route('demo.switch', 'super_admin') }}" class="px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/15 text-white font-bold text-sm border border-white/20 transition flex items-center gap-2">
                <i data-lucide="shield" class="w-4 h-4 text-brand-400"></i>
                <span>Explore Super Admin</span>
            </a>
        </div>
    </div>
</section>
@endsection
