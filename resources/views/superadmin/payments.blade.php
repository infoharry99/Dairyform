@extends('layouts.admin')

@section('title', 'Payment Approvals - Super Admin')
@section('page_title', 'Subscription Payments & Approvals')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
    Verification Gateway
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ proofModalPayment: null }">
    <!-- Payment Overview Notice -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-900">Subscription Payment Reconciliation</h4>
                <p class="text-xs text-slate-500">Approve pending UPI payments from newly registered dairies. Approving a payment automatically turns their subscription and tenant status to <strong>Active</strong>.</p>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Payment Transactions</h3>
            <span class="text-xs text-slate-500">Showing all direct subscription gateway receipts</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3">Transaction ID</th>
                        <th class="p-3">Dairy Shop</th>
                        <th class="p-3">Plan</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Payment Date</th>
                        <th class="p-3">Method</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Screenshot / Proof</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($payments as $p)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3 font-mono font-bold text-slate-900">{{ $p->transaction_id }}</td>
                        <td class="p-3">
                            <strong class="text-slate-900 block">{{ $p->dairy->name ?? 'Dairy' }}</strong>
                            <span class="text-[10px] text-slate-400">{{ $p->dairy->owner_name ?? '' }} ({{ $p->dairy->city ?? '' }})</span>
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-bold text-[10px]">
                                {{ $p->subscription->plan->name ?? 'Standard' }}
                            </span>
                        </td>
                        <td class="p-3 font-bold text-slate-900 text-sm">₹{{ number_format($p->amount) }}</td>
                        <td class="p-3 text-slate-600">{{ $p->payment_date->format('d M Y, h:i A') }}</td>
                        <td class="p-3">
                            <span class="uppercase font-bold text-[10px] text-slate-700 bg-slate-100 px-2 py-0.5 rounded">
                                {{ $p->payment_method }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($p->status === 'approved')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Approved</span>
                            @elseif($p->status === 'pending')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse">Pending Review</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Rejected</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <!-- Proof Trigger Button -->
                            <button type="button" @click="proofModalPayment = {{ json_encode($p) }}" 
                                    class="inline-flex items-center gap-1 text-[11px] text-indigo-600 hover:text-indigo-800 font-bold underline">
                                <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                <span>View Receipt</span>
                            </button>
                        </td>
                        <td class="p-3 text-right">
                            @if($p->status === 'pending')
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('superadmin.payments.approve', $p->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] shadow-sm transition">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('superadmin.payments.reject', $p->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-[11px] border border-rose-200 transition">
                                        Reject
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-[11px] text-slate-400 font-medium">Verified</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-slate-500">No subscription payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Verification Modal (As Required by Prompt) -->
    <div x-cloak x-show="proofModalPayment" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="proofModalPayment" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="proofModalPayment = null"></div>

            <div x-show="proofModalPayment" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border border-slate-200">
                <div class="bg-gradient-to-r from-slate-900 to-indigo-950 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest">Payment Verification Desk</span>
                        <h3 class="text-lg font-bold" x-text="'Tx: ' + proofModalPayment?.transaction_id"></h3>
                    </div>
                    <button @click="proofModalPayment = null" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Dairy Name:</span>
                            <strong class="text-slate-900" x-text="proofModalPayment?.dairy?.name ?? 'Annapurna Dairy'"></strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Subscription Plan:</span>
                            <strong class="text-indigo-700" x-text="proofModalPayment?.subscription?.plan?.name ?? 'Basic'"></strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Amount Paid:</span>
                            <strong class="text-slate-900 text-sm" x-text="'₹' + proofModalPayment?.amount"></strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Reference Number:</span>
                            <span class="font-mono text-slate-800" x-text="proofModalPayment?.reference_no ?? 'UPI/2948291048'"></span>
                        </div>
                    </div>

                    <!-- Mock Screenshot / Receipt Visual -->
                    <div>
                        <span class="font-bold text-slate-700 block mb-1">Customer Payment Screenshot:</span>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50 text-center">
                            <div class="max-w-xs mx-auto bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-left font-mono space-y-2">
                                <div class="flex items-center gap-2 border-b pb-2">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-900">UPI Transfer Successful</div>
                                        <div class="text-[9px] text-slate-400">Google Pay • UPI/2948291048</div>
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <div class="text-xl font-bold text-slate-900" x-text="'₹' + proofModalPayment?.amount"></div>
                                    <div class="text-[10px] text-slate-500">Paid to: MilkFlow Subscriptions</div>
                                </div>
                                <div class="text-[9px] text-slate-400 border-t pt-1">
                                    Time: Today • Bank Reference: 2948291048
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t flex items-center justify-between">
                    <button @click="proofModalPayment = null" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600">Close</button>
                    
                    <div class="flex items-center gap-2" x-show="proofModalPayment?.status === 'pending'">
                        <form :action="'/super-admin/payments/' + proofModalPayment?.id + '/approve'" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>Approve Payment & Activate</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
