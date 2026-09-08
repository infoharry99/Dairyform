@extends('layouts.admin')

@section('title', 'Platform Reports - Super Admin')
@section('page_title', 'Analytics & Network Reports')

@section('content')
<div class="space-y-6">
    <!-- Action Banner with Filters -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">SaaS Platform Growth & Milk Volume Analytics</h3>
            <p class="text-xs text-slate-500">Consolidated analytics across all registered dairies in Madhya Pradesh</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="alert('Exporting PDF Executive Summary...')" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5 shadow">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export PDF Summary
            </button>
            <button onclick="alert('Exporting Excel Financial Model...')" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow">
                <i data-lucide="sheet" class="w-3.5 h-3.5"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- 4 Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Milk Delivered</span>
            <div class="text-2xl font-black text-slate-900">1.2M Litres</div>
            <span class="text-[11px] text-emerald-600 font-semibold">+8.4% vs last month</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Network GMV</span>
            <div class="text-2xl font-black text-slate-900">₹7.44 Crores</div>
            <span class="text-[11px] text-slate-500">Gross milk transactions</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 block mb-1">Platform Subscription ARR</span>
            <div class="text-2xl font-black text-indigo-700">₹1.42 Crores</div>
            <span class="text-[11px] text-indigo-600 font-semibold">1,086 paying shops</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-500 block mb-1">Avg Subscription Churn</span>
            <div class="text-2xl font-black text-emerald-600">1.8%</div>
            <span class="text-[11px] text-slate-500">Industry leading retention</span>
        </div>
    </div>

    <!-- City Performance Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-sm font-bold text-slate-900">City Hub Performance Breakdown</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase tracking-wider">
                    <tr>
                        <th class="p-3">City Hub</th>
                        <th class="p-3">Active Dairies</th>
                        <th class="p-3">Total Customers</th>
                        <th class="p-3">Daily Litres</th>
                        <th class="p-3">Monthly GMV</th>
                        <th class="p-3">SaaS Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    <tr>
                        <td class="p-3 font-bold text-slate-900">Indore Hub</td>
                        <td class="p-3 font-bold text-indigo-700">482 Dairies</td>
                        <td class="p-3">14,200</td>
                        <td class="p-3 font-bold">185,000 L/day</td>
                        <td class="p-3 font-bold">₹3.33 Cr</td>
                        <td class="p-3 text-emerald-600 font-bold">₹5.12 Lakhs</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold text-slate-900">Bhopal Hub</td>
                        <td class="p-3 font-bold text-indigo-700">314 Dairies</td>
                        <td class="p-3">9,800</td>
                        <td class="p-3 font-bold">120,000 L/day</td>
                        <td class="p-3 font-bold">₹2.16 Cr</td>
                        <td class="p-3 text-emerald-600 font-bold">₹3.45 Lakhs</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold text-slate-900">Ujjain Hub</td>
                        <td class="p-3 font-bold text-indigo-700">178 Dairies</td>
                        <td class="p-3">5,100</td>
                        <td class="p-3 font-bold">65,000 L/day</td>
                        <td class="p-3 font-bold">₹1.17 Cr</td>
                        <td class="p-3 text-emerald-600 font-bold">₹1.92 Lakhs</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold text-slate-900">Dewas & Rau Hubs</td>
                        <td class="p-3 font-bold text-indigo-700">112 Dairies</td>
                        <td class="p-3">3,350</td>
                        <td class="p-3 font-bold">42,000 L/day</td>
                        <td class="p-3 font-bold">₹0.78 Cr</td>
                        <td class="p-3 text-emerald-600 font-bold">₹1.99 Lakhs</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
