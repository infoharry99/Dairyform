@extends('layouts.customer')

@section('title', 'My Profile - MilkFlow')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-brand-600 uppercase">Account Details</span>
            <h1 class="text-base font-black text-slate-900">Customer Profile</h1>
        </div>
        <span class="text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
            {{ $customer->customer_code }}
        </span>
    </div>

    <!-- Details Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4 text-xs">
        <div class="flex items-center gap-3 border-b pb-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white font-black text-lg flex items-center justify-center">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <div>
                <strong class="text-base text-slate-900 block">{{ $customer->name }}</strong>
                <span class="text-slate-500 font-mono">{{ $customer->phone }}</span>
            </div>
        </div>

        <div class="space-y-2.5 text-slate-600">
            <div class="flex justify-between">
                <span class="text-slate-400">Dairy Supplier:</span>
                <strong class="text-slate-900">{{ $customer->dairy->name }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Delivery Route:</span>
                <strong class="text-slate-900">{{ $customer->area }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Daily Milk:</span>
                <strong class="text-slate-900">{{ $customer->daily_quantity }} Litres ({{ ucfirst($customer->milk_type) }})</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Rate per Litre:</span>
                <strong class="text-slate-900">₹{{ $customer->rate_per_litre }}/L</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Delivery Time:</span>
                <strong class="text-slate-900 capitalize">{{ $customer->delivery_time }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Address:</span>
                <span class="text-slate-900 text-right max-w-xs">{{ $customer->address }}</span>
            </div>
        </div>

        @if($customer->notes)
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-600">
            <strong class="text-slate-800 block mb-0.5">Delivery Boy Instructions:</strong>
            {{ $customer->notes }}
        </div>
        @endif

        <div class="pt-2 border-t">
            <a href="{{ route('logout') }}" class="block w-full py-2.5 rounded-xl border border-rose-200 text-rose-600 font-bold text-center hover:bg-rose-50 transition">
                Sign Out
            </a>
        </div>
    </div>
</div>
@endsection
