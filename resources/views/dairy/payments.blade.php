@extends('layouts.admin')

@section('title', 'Payments & Collections - MilkFlow')
@section('page_title', 'Payment Receipts & Ledger')

@section('content')
<div class="space-y-6" x-data="{ recordPaymentModal: false }">
    <!-- Top Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Payment Collection & Ledger</h3>
            <p class="text-xs text-slate-500">Record cash received by delivery boys or at shop counter, plus reconcile online UPI payments.</p>
        </div>

        <button type="button" @click="recordPaymentModal = true" 
                class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition flex items-center gap-1.5">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Record Offline / Cash Payment</span>
        </button>
    </div>

    <!-- Payments Ledger Table (As Required by Prompt) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Payment Transactions History</h3>
            <span class="text-xs text-slate-400">{{ $payments->count() }} Payments Recorded</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3.5">Tx ID</th>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Linked Bill</th>
                        <th class="p-3.5">Amount</th>
                        <th class="p-3.5">Method</th>
                        <th class="p-3.5">Date & Time</th>
                        <th class="p-3.5">Reference / Notes</th>
                        <th class="p-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($payments as $pay)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3.5 font-mono font-bold text-slate-900">{{ $pay->transaction_id }}</td>
                        <td class="p-3.5">
                            <strong class="text-slate-900 block">{{ $pay->customer->name ?? 'Customer' }}</strong>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $pay->customer->phone ?? '' }}</span>
                        </td>
                        <td class="p-3.5 font-mono text-slate-700">{{ $pay->bill->bill_number ?? 'Counter Collection' }}</td>
                        <td class="p-3.5 font-black text-emerald-700 text-sm">₹{{ number_format($pay->amount) }}</td>
                        <td class="p-3.5">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase 
                                {{ $pay->payment_method === 'cash' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $pay->payment_method }}
                            </span>
                        </td>
                        <td class="p-3.5 text-slate-600">{{ $pay->payment_date->format('d M Y, h:i A') }}</td>
                        <td class="p-3.5 text-slate-600">{{ $pay->notes ?? $pay->reference_no }}</td>
                        <td class="p-3.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Approved ✓
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-500">No payment receipts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Record Payment (As Required by Prompt) -->
    <div x-cloak x-show="recordPaymentModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="recordPaymentModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="recordPaymentModal = false"></div>

            <div x-show="recordPaymentModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <div class="bg-brand-900 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-brand-300 uppercase tracking-widest">Manual Receipt Entry</span>
                        <h3 class="text-lg font-bold">Record Customer Payment</h3>
                    </div>
                    <button @click="recordPaymentModal = false" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('dairy.payments.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Customer *</label>
                        <select name="customer_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-medium">
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} (Pending: ₹{{ number_format($c->totalPendingDues()) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Amount Paid (₹) *</label>
                            <input type="number" step="10" name="amount" value="1480" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold text-emerald-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Payment Method *</label>
                            <select name="payment_method" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-medium">
                                <option value="cash">Cash (Counter/Boy)</option>
                                <option value="upi">UPI (GPay / PhonePe)</option>
                                <option value="bank_transfer">Bank Transfer (NEFT/IMPS)</option>
                                <option value="online">Online App Payment</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Reference / Notes</label>
                        <input type="text" name="notes" placeholder="e.g. Received by Suresh Parmar on morning route" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                    </div>

                    <div class="pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="recordPaymentModal = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow">
                            Save Payment & Update Dues
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
