@extends('layouts.customer')

@section('title', 'Pay Milk Bill Online - MilkFlow')

@section('content')
<div class="space-y-4" x-data="{
    method: 'upi',
    upiApp: 'gpay',
    paying: false,
    paidSuccess: {{ session('payment_success') ? 'true' : 'false' }},
    txDetails: {{ json_encode(session('payment_success')) }}
}" x-init="if (paidSuccess) {
    confetti({ particleCount: 120, spread: 70, origin: { y: 0.6 } });
}">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-emerald-600 uppercase">Instant Payment Gateway</span>
            <h1 class="text-base font-black text-slate-900">Pay Outstanding Milk Bill</h1>
        </div>
        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 flex items-center gap-1">
            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> 100% Secure
        </span>
    </div>

    <!-- SUCCESS SCREEN (If payment completed) -->
    <div x-show="paidSuccess" class="bg-white p-6 rounded-3xl border border-emerald-300 shadow-xl text-center space-y-4">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-inner animate-bounce">
            <i data-lucide="check-circle" class="w-10 h-10"></i>
        </div>

        <div>
            <h2 class="text-xl font-black text-slate-900">Payment Successful!</h2>
            <p class="text-xs text-slate-500 mt-1">Your milk bill payment has been received and verified.</p>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-left space-y-2 font-mono">
            <div class="flex justify-between">
                <span class="text-slate-500">Transaction ID:</span>
                <strong class="text-slate-900" x-text="txDetails?.tx_id ?? 'MF202609080001'"></strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Amount Paid:</span>
                <strong class="text-emerald-600 text-sm" x-text="'₹' + (txDetails?.amount ?? '1480')"></strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Bill Status:</span>
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]" x-text="txDetails?.bill_status ?? 'PAID'"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Recipient:</span>
                <span class="text-slate-800">{{ $customer->dairy->name }}</span>
            </div>
        </div>

        <p class="text-[11px] text-slate-400">A payment receipt SMS and WhatsApp confirmation has been dispatched to {{ $customer->phone }}.</p>

        <a href="{{ route('customer.dashboard') }}" class="block w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow transition">
            Back to Dashboard
        </a>
    </div>

    <!-- PAYMENT FORM SCREEN (When not yet paid) -->
    <div x-show="!paidSuccess" class="space-y-4">
        <!-- Amount to Pay Card -->
        <div class="bg-gradient-to-br from-slate-900 to-brand-950 text-white p-5 rounded-3xl shadow-md space-y-2">
            <span class="text-[10px] uppercase font-bold text-brand-300 tracking-wider">September 2026 Pending Bill</span>
            <div class="flex items-baseline justify-between">
                <div class="text-3xl font-black">₹1,480.00</div>
                <span class="px-2 py-0.5 rounded bg-white/20 text-white text-[10px] font-bold">Due Now</span>
            </div>
            <p class="text-[11px] text-slate-300 pt-1">Billed by {{ $customer->dairy->name }} for 58L Cow Milk + Products</p>
        </div>

        <!-- Payment Method Tabs -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Select Payment Method</h3>

            <div class="grid grid-cols-3 gap-2 text-xs font-bold">
                <button type="button" @click="method = 'upi'" 
                        :class="method === 'upi' ? 'border-2 border-emerald-600 bg-emerald-50/50 text-emerald-900' : 'border border-slate-200 text-slate-600 hover:bg-slate-50'"
                        class="p-3 rounded-2xl flex flex-col items-center gap-1.5 transition">
                    <i data-lucide="smartphone" class="w-5 h-5 text-emerald-600"></i>
                    <span>UPI / Apps</span>
                </button>

                <button type="button" @click="method = 'card'" 
                        :class="method === 'card' ? 'border-2 border-emerald-600 bg-emerald-50/50 text-emerald-900' : 'border border-slate-200 text-slate-600 hover:bg-slate-50'"
                        class="p-3 rounded-2xl flex flex-col items-center gap-1.5 transition">
                    <i data-lucide="credit-card" class="w-5 h-5 text-indigo-600"></i>
                    <span>Debit Card</span>
                </button>

                <button type="button" @click="method = 'netbanking'" 
                        :class="method === 'netbanking' ? 'border-2 border-emerald-600 bg-emerald-50/50 text-emerald-900' : 'border border-slate-200 text-slate-600 hover:bg-slate-50'"
                        class="p-3 rounded-2xl flex flex-col items-center gap-1.5 transition">
                    <i data-lucide="landmark" class="w-5 h-5 text-amber-600"></i>
                    <span>Net Banking</span>
                </button>
            </div>

            <!-- UPI App Selectors -->
            <div x-show="method === 'upi'" class="space-y-3 pt-2">
                <span class="text-[11px] font-bold text-slate-700 block">Choose Your Preferred UPI App:</span>
                <div class="space-y-2 text-xs">
                    <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 hover:border-emerald-500 cursor-pointer transition">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="app" x-model="upiApp" value="gpay" checked class="text-emerald-600 focus:ring-emerald-500">
                            <strong class="text-slate-900">Google Pay (GPay)</strong>
                        </div>
                        <span class="text-[10px] text-slate-400 font-semibold">Fastest</span>
                    </label>

                    <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 hover:border-emerald-500 cursor-pointer transition">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="app" x-model="upiApp" value="phonepe" class="text-emerald-600 focus:ring-emerald-500">
                            <strong class="text-slate-900">PhonePe</strong>
                        </div>
                        <span class="text-[10px] text-slate-400 font-semibold">Instant</span>
                    </label>

                    <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-200 hover:border-emerald-500 cursor-pointer transition">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="app" x-model="upiApp" value="paytm" class="text-emerald-600 focus:ring-emerald-500">
                            <strong class="text-slate-900">Paytm UPI</strong>
                        </div>
                        <span class="text-[10px] text-slate-400 font-semibold">Instant</span>
                    </label>
                </div>
            </div>

            <!-- Card simulation view -->
            <div x-show="method === 'card'" x-cloak class="space-y-3 pt-2 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Card Number</label>
                    <input type="text" value="4532 •••• •••• 8912" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-mono">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Expiry</label>
                        <input type="text" value="08/29" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">CVV</label>
                        <input type="password" value="•••" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-mono">
                    </div>
                </div>
            </div>

            <!-- Netbanking simulation view -->
            <div x-show="method === 'netbanking'" x-cloak class="pt-2 text-xs">
                <label class="block font-bold text-slate-700 mb-1">Select Bank</label>
                <select class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 font-medium">
                    <option>State Bank of India (SBI)</option>
                    <option>HDFC Bank</option>
                    <option>ICICI Bank</option>
                    <option>Bank of Baroda</option>
                </select>
            </div>
        </div>

        <!-- Simulated Submit Form -->
        <form action="{{ route('customer.pay') }}" method="POST">
            @csrf
            <input type="hidden" name="amount" value="1480">
            <input type="hidden" name="payment_method" :value="method">

            <button type="submit" 
                    class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-600/25 transition flex items-center justify-center gap-2">
                <i data-lucide="lock" class="w-4 h-4"></i>
                <span>Pay ₹1,480 via UPI & Generate Receipt</span>
            </button>
        </form>

        <div class="text-center text-[10px] text-slate-400 flex items-center justify-center gap-1.5">
            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
            <span>Instant sync: updates Dairy Admin & Super Admin revenue immediately</span>
        </div>
    </div>
</div>
@endsection
