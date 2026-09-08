@extends('layouts.customer')

@section('title', 'My Bills & Invoices - MilkFlow')

@section('content')
<div class="space-y-4" x-data="{ invoiceModal: null }">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-brand-600 uppercase">Billing Ledger</span>
            <h1 class="text-base font-black text-slate-900">My Milk Bills</h1>
        </div>
        <a href="{{ route('customer.payments') }}" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-sm">
            Pay Dues
        </a>
    </div>

    <!-- Bills List -->
    <div class="space-y-3">
        @foreach($bills as $bill)
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-start justify-between border-b pb-3">
                <div>
                    <span class="font-mono text-[10px] text-slate-400 block font-bold">{{ $bill->bill_number }}</span>
                    <h3 class="text-base font-extrabold text-slate-900">{{ $bill->month_year }}</h3>
                    <span class="text-[11px] text-slate-500">Due Date: {{ $bill->due_date->format('d M Y') }}</span>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase
                    {{ $bill->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $bill->status }}
                </span>
            </div>

            <!-- Breakdown -->
            <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 text-xs space-y-1.5 text-slate-600">
                <div class="flex justify-between">
                    <span>Milk Delivered ({{ $bill->total_litres }} L @ ₹{{ $bill->milk_rate }}):</span>
                    <strong class="text-slate-900">₹{{ number_format($bill->subtotal) }}</strong>
                </div>
                @if($bill->additional_products_amount > 0)
                <div class="flex justify-between">
                    <span>Additional Products (Paneer/Ghee):</span>
                    <strong class="text-slate-900">₹{{ number_format($bill->additional_products_amount) }}</strong>
                </div>
                @endif
                @if($bill->discount_amount > 0)
                <div class="flex justify-between text-emerald-600">
                    <span>Special Discount:</span>
                    <strong>-₹{{ number_format($bill->discount_amount) }}</strong>
                </div>
                @endif
                <div class="pt-2 border-t flex justify-between font-bold text-slate-900">
                    <span>Total Amount:</span>
                    <span class="text-sm">₹{{ number_format($bill->total_amount) }}</span>
                </div>
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>Amount Paid:</span>
                    <span>₹{{ number_format($bill->paid_amount) }}</span>
                </div>
                @if($bill->pending_amount > 0)
                <div class="flex justify-between text-rose-600 font-black text-sm pt-1 border-t">
                    <span>Remaining Due:</span>
                    <span>₹{{ number_format($bill->pending_amount) }}</span>
                </div>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="invoiceModal = {{ json_encode($bill) }}" 
                        class="flex-1 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                    <span>View Full Statement</span>
                </button>
                @if($bill->pending_amount > 0)
                <a href="{{ route('customer.payments') }}?bill_id={{ $bill->id }}" 
                   class="flex-1 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-1.5">
                    <i data-lucide="smartphone" class="w-3.5 h-3.5"></i>
                    <span>Pay ₹{{ number_format($bill->pending_amount) }}</span>
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal: View Full Statement -->
    <div x-cloak x-show="invoiceModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="invoiceModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="invoiceModal = null"></div>

            <div x-show="invoiceModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-sm sm:w-full border border-slate-200">
                <div class="p-6 space-y-4 text-xs">
                    <div class="text-center border-b pb-4">
                        <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center font-bold mx-auto mb-2">
                            <i data-lucide="milk" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">{{ $customer->dairy->name }}</h3>
                        <p class="text-[11px] text-slate-500 font-mono" x-text="invoiceModal?.bill_number"></p>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Customer:</span>
                            <strong class="text-slate-900">{{ $customer->name }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Period:</span>
                            <strong class="text-slate-900" x-text="invoiceModal?.month_year"></strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Total Litres:</span>
                            <strong class="text-slate-900" x-text="invoiceModal?.total_litres + ' Litres'"></strong>
                        </div>
                        <div class="flex justify-between font-bold text-sm border-t pt-2">
                            <span>Total Due:</span>
                            <span class="text-brand-600" x-text="'₹' + invoiceModal?.total_amount"></span>
                        </div>
                    </div>

                    <div class="pt-4 border-t flex justify-between items-center">
                        <button @click="invoiceModal = null" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-semibold">Close</button>
                        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs shadow flex items-center gap-1.5">
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span>Print / PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
