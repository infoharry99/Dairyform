@extends('layouts.customer')

@section('title', 'Milk Consumption Calendar - MilkFlow')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-brand-600 uppercase">Consumption Log</span>
            <h1 class="text-base font-black text-slate-900">Daily Milk History</h1>
        </div>
        <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
            September 2026
        </span>
    </div>

    <!-- Monthly Summary Pill -->
    <div class="bg-brand-50 p-4 rounded-2xl border border-brand-200 flex items-center justify-between text-xs">
        <div>
            <span class="text-brand-800 font-semibold block">Total Delivered in Sept:</span>
            <strong class="text-xl font-black text-brand-950">58.0 Litres</strong>
        </div>
        <div class="text-right">
            <span class="text-brand-800 font-semibold block">Avg Daily Drop:</span>
            <strong class="text-base font-bold text-brand-950">2.0 L/day</strong>
        </div>
    </div>

    <!-- Daily Log List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 space-y-2">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Shift Breakdown</h3>
        <div class="space-y-2 text-xs">
            @forelse($records as $rec)
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-[11px]">
                        {{ $rec->date->format('d') }}
                    </div>
                    <div>
                        <strong class="text-slate-900 block">{{ $rec->date->format('l, d M Y') }}</strong>
                        <span class="text-[10px] text-slate-500 capitalize">{{ $rec->shift }} Shift • {{ $rec->milk_type }} Milk</span>
                    </div>
                </div>

                <div class="text-right">
                    <div class="font-black text-slate-900 text-sm">{{ $rec->quantity }} Litres</div>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold {{ $rec->status === 'delivered' ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $rec->status === 'delivered' ? 'Delivered ✓' : ucfirst($rec->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="py-8 text-center text-xs text-slate-500">No delivery logs recorded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
