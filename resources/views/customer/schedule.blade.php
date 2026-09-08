@extends('layouts.customer')

@section('title', 'Delivery Schedule & Pause - MilkFlow')

@section('content')
<div class="space-y-4" x-data="{ tab: 'pause' }">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-brand-600 uppercase">Self-Service</span>
            <h1 class="text-base font-black text-slate-900">Manage Delivery Schedule</h1>
        </div>
        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Active</span>
    </div>

    <!-- Toggle between Pause and Modify Quantity -->
    <div class="grid grid-cols-2 gap-2 text-xs font-bold bg-slate-200/80 p-1 rounded-2xl">
        <button type="button" @click="tab = 'pause'" 
                :class="tab === 'pause' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600'"
                class="py-2 rounded-xl transition">
            Pause Delivery (Vacation)
        </button>
        <button type="button" @click="tab = 'modify'" 
                :class="tab === 'modify' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600'"
                class="py-2 rounded-xl transition">
            Request Extra Milk
        </button>
    </div>

    <!-- Tab 1: Vacation Pause Request Form -->
    <div x-show="tab === 'pause'" class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Going Out of Town?</h3>
            <p class="text-xs text-slate-500">Temporarily pause morning deliveries so milk is not wasted while you travel.</p>
        </div>

        <form action="{{ route('customer.schedule.request') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="request_type" value="pause">

            <div>
                <label class="block font-bold text-slate-700 mb-1">Pause Start Date *</label>
                <input type="date" name="start_date" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Resume Delivery Date *</label>
                <input type="date" name="end_date" value="{{ \Carbon\Carbon::tomorrow()->addDays(3)->format('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Reason (Optional)</label>
                <input type="text" name="reason" placeholder="e.g. Out of town for weekend trip" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow transition">
                Submit Pause Request
            </button>
        </form>
    </div>

    <!-- Tab 2: Extra Milk Request Form -->
    <div x-show="tab === 'modify'" x-cloak class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Need Extra Milk for Guests?</h3>
            <p class="text-xs text-slate-500">Temporarily increase your quantity for upcoming festivals, pooja, or family visits.</p>
        </div>

        <form action="{{ route('customer.schedule.request') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="request_type" value="modify">

            <div>
                <label class="block font-bold text-slate-700 mb-1">Target Date *</label>
                <input type="date" name="effective_date" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Requested Total Litres *</label>
                <select name="new_quantity" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-bold text-brand-700">
                    <option value="3.0">3.0 Litres (+1L extra)</option>
                    <option value="4.0" selected>4.0 Litres (+2L extra)</option>
                    <option value="5.0">5.0 Litres (+3L extra)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Reason / Note</label>
                <input type="text" name="reason" placeholder="e.g. Guests visiting for Sunday lunch" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow transition">
                Submit Extra Milk Request
            </button>
        </form>
    </div>
</div>
@endsection
