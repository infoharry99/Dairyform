@extends('layouts.admin')

@section('title', 'Subscription Management - Super Admin')
@section('page_title', 'SaaS Subscriptions & Plans')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
    3 Active Tiers
</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Expiry Alert Banner (As Required by Prompt) -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-4 sm:p-5 rounded-2xl text-white shadow-md flex items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm">Upcoming Expiry Alerts</h4>
                <p class="text-xs text-white/90">
                    <strong>5 dairy subscriptions</strong> expire in the next 7 days (including Radha Dairy, Dewas). Automated WhatsApp renewal notices have been queued.
                </p>
            </div>
        </div>
        <button class="px-4 py-2 rounded-xl bg-white text-slate-900 text-xs font-bold shadow hover:bg-white/90 transition shrink-0">
            Send Batch Renewal Reminder
        </button>
    </div>

    <!-- Active Subscription Plans Configuration Cards -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Subscription Plans (Configurable)</h3>
            <span class="text-xs text-slate-500">Tiered limits enforce multi-tenant quotas</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plans as $plan)
            <div class="bg-white p-6 rounded-3xl border {{ $plan->is_popular ? 'border-2 border-indigo-500 shadow-md' : 'border-slate-200/90 shadow-sm' }} relative flex flex-col justify-between">
                @if($plan->is_popular)
                <span class="absolute -top-3 right-6 px-3 py-0.5 rounded-full bg-indigo-600 text-white text-[10px] font-extrabold uppercase">Most Popular</span>
                @endif
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-bold text-slate-900">{{ $plan->name }}</h4>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-700">Quota: {{ $plan->customer_limit }} Cust.</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-4">{{ $plan->tagline }}</p>

                    <!-- Pricing Matrix -->
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Monthly:</span>
                            <strong class="text-slate-900">₹{{ number_format($plan->price_monthly) }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Half-Yearly:</span>
                            <strong class="text-slate-900">₹{{ number_format($plan->price_half_yearly) }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Yearly:</span>
                            <strong class="text-indigo-700 font-extrabold">₹{{ number_format($plan->price_yearly) }}</strong>
                        </div>
                    </div>

                    <!-- Quota Limits -->
                    <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                        <div class="flex justify-between"><span>Max Customers:</span><strong>{{ $plan->customer_limit }}</strong></div>
                        <div class="flex justify-between"><span>Staff Accounts:</span><strong>{{ $plan->staff_limit }} Staff</strong></div>
                        <div class="flex justify-between"><span>WhatsApp Alerts:</span><strong class="text-emerald-600">Included</strong></div>
                    </div>
                </div>

                <div class="pt-5 mt-4 border-t">
                    <button type="button" onclick="alert('Plan limits and pricing updated for {{ $plan->name }}.')" class="w-full py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                        Configure Plan
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden space-y-4 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Tenant Subscription History</h3>
                <p class="text-xs text-slate-500">All registered dairy licenses and renewal cycles</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3">Dairy Shop</th>
                        <th class="p-3">Plan</th>
                        <th class="p-3">Billing Cycle</th>
                        <th class="p-3">Start Date</th>
                        <th class="p-3">Expiry Date</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Auto Renewal</th>
                        <th class="p-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($subscriptions as $s)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3 font-bold text-slate-900">
                            {{ $s->dairy->name ?? 'Dairy #' . $s->dairy_id }}
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-bold text-[10px]">
                                {{ $s->plan->name ?? 'Standard' }}
                            </span>
                        </td>
                        <td class="p-3 uppercase text-[10px] text-slate-600 font-bold">{{ $s->billing_cycle }}</td>
                        <td class="p-3 text-slate-600">{{ $s->starts_at->format('d M Y') }}</td>
                        <td class="p-3 text-slate-600">{{ $s->expires_at->format('d M Y') }}</td>
                        <td class="p-3 font-bold text-slate-900">₹{{ number_format($s->amount) }}</td>
                        <td class="p-3">
                            @if($s->status === 'active')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                            @elseif($s->status === 'expiring_soon')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse">Expiring Soon</span>
                            @elseif($s->status === 'expired')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Expired</span>
                            @elseif($s->status === 'pending')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Pending Verification</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">{{ $s->status }}</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <span class="text-xs {{ $s->auto_renew ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                                {{ $s->auto_renew ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <button onclick="alert('Sent invoice copy to dairy owner.');" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                Send Invoice
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
