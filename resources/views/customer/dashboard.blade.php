@extends('layouts.customer')

@section('title', 'My Milk Dashboard - ' . $customer->name)

@section('content')
<div class="space-y-4">
    <!-- Greeting Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[11px] font-semibold text-slate-400">Namaste 🙏</span>
            <h1 class="text-lg font-black text-slate-900">Good Morning, {{ explode(' ', $customer->name)[0] }} 👋</h1>
            <p class="text-[11px] text-slate-500">{{ $customer->address }}</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 border border-brand-200">
            {{ $customer->customer_code }}
        </span>
    </div>

    <!-- Today's Milk Highlight Card (As Required by Prompt) -->
    <div class="bg-gradient-to-br from-brand-600 to-teal-800 text-white p-5 rounded-3xl shadow-lg relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <span class="text-xs uppercase font-extrabold tracking-wider text-brand-200 block">Today's Milk Delivery</span>
                <div class="text-3xl font-black mt-1">2.0 <span class="text-lg font-bold text-brand-200">Litres</span></div>
                <span class="text-xs text-brand-100 font-semibold block mt-0.5">Fresh Pure Cow Milk</span>
            </div>

            <!-- Delivery Status Badge -->
            <div class="text-right">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white/20 text-white font-bold text-xs backdrop-blur-md shadow-sm">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-300"></i>
                    <span>Delivered ✓</span>
                </span>
                <span class="text-[10px] text-brand-200 block mt-1">Dropped at 06:45 AM</span>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-brand-100 relative z-10">
            <span>Delivered by Suresh (Boy)</span>
            <span class="font-bold text-white">Can Placed in Holder</span>
        </div>
    </div>

    <!-- 4 Quick Buttons (As Required by Prompt) -->
    <div class="grid grid-cols-4 gap-2 text-center text-[11px] font-bold">
        <a href="{{ route('customer.milk') }}" class="p-3 bg-white rounded-2xl border border-slate-200 shadow-sm hover:border-brand-500 transition group flex flex-col items-center gap-1.5">
            <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                <i data-lucide="sun" class="w-4 h-4"></i>
            </span>
            <span class="text-slate-800">Today's Milk</span>
        </a>

        <a href="{{ route('customer.bills') }}" class="p-3 bg-white rounded-2xl border border-slate-200 shadow-sm hover:border-brand-500 transition group flex flex-col items-center gap-1.5">
            <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition">
                <i data-lucide="receipt" class="w-4 h-4"></i>
            </span>
            <span class="text-slate-800">My Bill</span>
        </a>

        <a href="{{ route('customer.payments') }}" class="p-3 bg-emerald-600 text-white rounded-2xl shadow-md hover:bg-emerald-700 transition group flex flex-col items-center gap-1.5">
            <span class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center group-hover:scale-110 transition">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
            </span>
            <span>Pay Now</span>
        </a>

        <a href="{{ route('customer.milk') }}" class="p-3 bg-white rounded-2xl border border-slate-200 shadow-sm hover:border-brand-500 transition group flex flex-col items-center gap-1.5">
            <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition">
                <i data-lucide="history" class="w-4 h-4"></i>
            </span>
            <span class="text-slate-800">History</span>
        </a>
    </div>

    <!-- Monthly Summary & Bill Status Card (As Required by Prompt) -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Current Month Status</span>
                <h3 class="text-sm font-extrabold text-slate-900">September 2026 Billing</h3>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                PARTIAL DUE
            </span>
        </div>

        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 block text-[10px]">Total Milk Consumed</span>
                <strong class="text-base text-slate-900">58 Litres</strong>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 block text-[10px]">Current Bill Total</span>
                <strong class="text-base text-slate-900">₹3,880</strong>
            </div>
            <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-800">
                <span class="text-emerald-600 block text-[10px]">Amount Paid</span>
                <strong class="text-base font-bold">₹2,400</strong>
            </div>
            <div class="p-3 bg-rose-50 rounded-2xl text-rose-800">
                <span class="text-rose-600 block text-[10px]">Pending Due</span>
                <strong class="text-base font-black text-rose-600">₹1,480</strong>
            </div>
        </div>

        @if($currentBill && $currentBill->pending_amount > 0)
        <a href="{{ route('customer.payments') }}" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 transition">
            <i data-lucide="smartphone" class="w-4 h-4"></i>
            <span>Pay Pending Due ₹{{ number_format($currentBill->pending_amount) }} via UPI</span>
        </a>
        @endif
    </div>

    <!-- Quick Actions: Pause Delivery / Extra Milk -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between text-xs">
        <div>
            <strong class="text-slate-900 block">Traveling or Need Extra Milk?</strong>
            <span class="text-[11px] text-slate-500">Request vacation pause without calling.</span>
        </div>
        <a href="{{ route('customer.schedule') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold transition">
            Adjust Schedule
        </a>
    </div>

    <!-- Recent Daily Milk Log -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Recent Milk Deliveries</h3>
            <a href="{{ route('customer.milk') }}" class="text-[11px] text-brand-600 font-bold">View Calendar &rarr;</a>
        </div>

        <div class="space-y-2 text-xs">
            @foreach($recentRecords as $r)
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full {{ $r->status === 'delivered' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    <div>
                        <strong class="text-slate-900 block">{{ $r->date->format('D, d M') }}</strong>
                        <span class="text-[10px] text-slate-400 capitalize">{{ $r->shift }} Shift • Cow Milk</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-bold text-slate-900 block">{{ $r->quantity }} L</span>
                    <span class="text-[10px] text-slate-500">₹{{ $r->amount }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
