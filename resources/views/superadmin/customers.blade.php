@extends('layouts.admin')

@section('title', 'All Customers - Super Admin')
@section('page_title', 'Multi-Tenant Customers Overview')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
    {{ $customers->count() }} Sample Customers (32,450 Network-Wide)
</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Network-Wide Milk Consumers</h3>
            <p class="text-xs text-slate-500">Every customer is logically isolated under their respective dairy shop tenant.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="alert('Exporting customer dataset to CSV...')" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 flex items-center gap-1.5 shadow-sm">
                <i data-lucide="download" class="w-3.5 h-3.5"></i> Export CSV
            </button>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Assigned Dairy Shop</th>
                        <th class="p-3">Area / City</th>
                        <th class="p-3">Daily Milk</th>
                        <th class="p-3">Milk Type</th>
                        <th class="p-3">Shift</th>
                        <th class="p-3">Rate</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($customers as $c)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3">
                            <strong class="text-slate-900 block">{{ $c->name }}</strong>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $c->customer_code }} • {{ $c->phone }}</span>
                        </td>
                        <td class="p-3 font-semibold text-indigo-700">{{ $c->dairy->name ?? 'Shree Krishna Dairy' }}</td>
                        <td class="p-3 text-slate-600">{{ $c->area }}, {{ $c->dairy->city ?? 'Indore' }}</td>
                        <td class="p-3 font-bold text-slate-900">{{ $c->daily_quantity }} L</td>
                        <td class="p-3"><span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-semibold text-[10px] uppercase">{{ $c->milk_type }}</span></td>
                        <td class="p-3 capitalize text-slate-700">{{ $c->delivery_time }}</td>
                        <td class="p-3 font-bold text-slate-900">₹{{ $c->rate_per_litre }}/L</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst($c->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
