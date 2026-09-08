@extends('layouts.admin')

@section('title', 'Daily Route Delivery - MilkFlow')
@section('page_title', 'Route Delivery Management')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    4 Street Routes • Indore City
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeRoute: 'Scheme 54' }">
    <!-- Top Route & Shift Filter Header -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                <i data-lucide="map" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Area Street Route Dispatcher</h3>
                <p class="text-xs text-slate-500">Assign delivery boys, monitor drop completion, and trace routes.</p>
            </div>
        </div>

        <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-bold">
            <a href="{{ route('dairy.delivery', ['shift' => 'morning']) }}" class="px-4 py-2 rounded-lg {{ $shift === 'morning' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500' }}">Morning Shift</a>
            <a href="{{ route('dairy.delivery', ['shift' => 'evening']) }}" class="px-4 py-2 rounded-lg {{ $shift === 'evening' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500' }}">Evening Shift</a>
        </div>
    </div>

    <!-- 4 Route Selector Tabs -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($routes as $areaName => $data)
        <div @click="activeRoute = '{{ $areaName }}'" 
             :class="activeRoute === '{{ $areaName }}' ? 'border-2 border-brand-600 bg-white ring-2 ring-brand-500/20 shadow-md' : 'border border-slate-200 bg-white hover:border-slate-300'"
             class="p-4 rounded-2xl cursor-pointer transition">
            <div class="flex items-center justify-between mb-1.5">
                <h4 class="font-bold text-slate-900 text-sm">{{ $areaName }}</h4>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-xs text-slate-500 mb-2">Boy: <strong class="text-slate-800">{{ $data['delivery_boy'] }}</strong></div>
            <div class="flex items-center justify-between text-[11px] pt-2 border-t border-slate-100">
                <span class="text-slate-600 font-semibold">{{ $data['customers']->count() }} Drops</span>
                <span class="text-brand-600 font-bold">Active</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Selected Route Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-4">
            <div>
                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Active Route Street List</span>
                <h3 class="text-xl font-black text-slate-900 mt-0.5" x-text="activeRoute + ' Route Drops'"></h3>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="alert('Sent WhatsApp Route Sheet to Delivery Boy.');" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm flex items-center gap-1.5 transition">
                    <i data-lucide="share-2" class="w-3.5 h-3.5"></i>
                    <span>Send Route Sheet to Delivery Boy</span>
                </button>
            </div>
        </div>

        @foreach($routes as $areaName => $data)
        <div x-show="activeRoute === '{{ $areaName }}'" class="space-y-4">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                <div>
                    <span class="text-slate-500">Assigned Delivery Boy:</span>
                    <strong class="text-slate-900 ml-1">{{ $data['delivery_boy'] }}</strong>
                    <span class="text-slate-400 font-mono ml-2">({{ $data['phone'] }})</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-emerald-700 font-bold">All cans chilled & sealed</span>
                </div>
            </div>

            <!-- Customer Drops on This Route -->
            <div class="divide-y divide-slate-100 text-xs">
                @foreach($data['customers'] as $idx => $cust)
                <div class="py-3.5 flex items-center justify-between gap-4 hover:bg-slate-50/80 px-3 rounded-xl transition">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-[10px]">
                            {{ $idx + 1 }}
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <strong class="text-slate-900 text-sm">{{ $cust->name }}</strong>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700">{{ $cust->milk_type }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $cust->address }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <span class="text-sm font-black text-slate-900 block">{{ $cust->daily_quantity }} Litres</span>
                            <span class="text-[10px] text-slate-400">₹{{ $cust->daily_quantity * $cust->rate_per_litre }}</span>
                        </div>

                        <div>
                            @if($cust->status === 'active')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] flex items-center gap-1">
                                    <i data-lucide="check" class="w-3 h-3"></i> Delivered
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">
                                    Paused
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
