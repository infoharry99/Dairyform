@extends('layouts.public')

@section('title', 'Pricing Plans - MilkFlow Dairy SaaS')

@section('content')
<div class="py-16 bg-slate-50 border-b border-slate-200" x-data="{ cycle: 'monthly' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Plans & Pricing</span>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Affordable Plans for Every Dairy</h1>
        <p class="text-base text-slate-600 mt-4">Simple, transparent pricing with no hidden hardware or transaction fees. Change or cancel anytime.</p>

        <!-- Billing Cycle Switcher -->
        <div class="pt-8 flex items-center justify-center">
            <div class="inline-flex items-center p-1.5 rounded-2xl bg-slate-200/80 border border-slate-300/60 text-xs font-bold">
                <button @click="cycle = 'monthly'" 
                        :class="cycle === 'monthly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-5 py-2.5 rounded-xl transition">
                    Monthly
                </button>
                <button @click="cycle = 'half_yearly'" 
                        :class="cycle === 'half_yearly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-5 py-2.5 rounded-xl transition flex items-center gap-1.5">
                    Half-Yearly <span class="text-[10px] text-brand-700 bg-brand-100 px-2 py-0.5 rounded-full font-bold">Save 10%</span>
                </button>
                <button @click="cycle = 'yearly'" 
                        :class="cycle === 'yearly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-5 py-2.5 rounded-xl transition flex items-center gap-1.5">
                    Yearly <span class="text-[10px] text-brand-700 bg-brand-100 px-2 py-0.5 rounded-full font-bold">Save 20%</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="py-20 bg-white" x-data="{ cycle: 'monthly' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mb-20">
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

                    <div class="my-6">
                        <span class="text-4xl font-extrabold text-slate-900">
                            ₹{{ number_format($plan->price_monthly) }}
                        </span>
                        <span class="text-xs text-slate-500 font-medium">/month</span>
                    </div>

                    <div class="pt-6 border-t border-slate-100 space-y-3">
                        <div class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">Key Features:</div>
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
                        Subscribe to {{ $plan->name }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Comprehensive Comparison Table -->
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-slate-900 text-center mb-8">Detailed Feature Comparison</h2>
            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="p-4">Platform Feature</th>
                            <th class="p-4 text-center">Basic (₹499)</th>
                            <th class="p-4 text-center bg-brand-50/50 text-brand-900">Standard (₹999)</th>
                            <th class="p-4 text-center">Premium (₹1,999)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Customer Capacity</td>
                            <td class="p-4 text-center">Up to 100</td>
                            <td class="p-4 text-center bg-brand-50/20 font-bold text-brand-700">Up to 500</td>
                            <td class="p-4 text-center font-bold text-slate-900">Unlimited (2,000+)</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Staff / Delivery Logins</td>
                            <td class="p-4 text-center">2 Staff</td>
                            <td class="p-4 text-center bg-brand-50/20 font-bold text-brand-700">6 Staff</td>
                            <td class="p-4 text-center font-bold text-slate-900">20 Staff Accounts</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Morning & Evening Shift Milk</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center bg-brand-50/20 text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">WhatsApp PDF Invoices</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Online UPI & QR Payments</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Customer Self-Service Mobile App</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Additional Dairy Products (Paneer, Ghee, Curd)</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-emerald-600 font-bold">✓ Included</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Multi-Area Route Management</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-slate-400">—</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ Included</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-slate-900">Dedicated Account Manager</td>
                            <td class="p-4 text-center text-slate-400">—</td>
                            <td class="p-4 text-center bg-brand-50/20 text-slate-400">—</td>
                            <td class="p-4 text-center text-emerald-600 font-bold">✓ 24/7 Dedicated</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
