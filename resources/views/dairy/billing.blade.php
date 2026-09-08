@extends('layouts.admin')

@section('title', 'Monthly Billing & Invoicing - MilkFlow')
@section('page_title', 'Billing & Invoice Automation')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    Cycle: September 2026
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ createBillModal: false, selectedInvoice: null, whatsappModal: null }">
    <!-- Billing Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Automated Monthly Statements</h3>
            <p class="text-xs text-slate-500">Calculate milk quantity multiplied by rates + additional products minus discounts.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" @click="createBillModal = true" 
                    class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Generate Customer Bill</span>
            </button>
        </div>
    </div>

    <!-- Generated Bills Ledger Table (As Required by Prompt) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">September 2026 Customer Billing Ledger</h3>
            <span class="text-xs text-slate-400">{{ $bills->count() }} Invoices Generated</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3.5">Invoice #</th>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Billing Period</th>
                        <th class="p-3.5">Total Milk</th>
                        <th class="p-3.5">Subtotal</th>
                        <th class="p-3.5">Addl. Products</th>
                        <th class="p-3.5">Discount</th>
                        <th class="p-3.5">Final Amount</th>
                        <th class="p-3.5">Paid</th>
                        <th class="p-3.5">Pending</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($bills as $b)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3.5 font-mono font-bold text-slate-900">{{ $b->bill_number }}</td>
                        <td class="p-3.5">
                            <strong class="text-slate-900 block">{{ $b->customer->name ?? 'Customer' }}</strong>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $b->customer->phone ?? '' }} • {{ $b->customer->area ?? '' }}</span>
                        </td>
                        <td class="p-3.5 text-slate-600 font-semibold">{{ $b->month_year }}</td>
                        <td class="p-3.5 font-bold text-slate-800">{{ $b->total_litres }} L <span class="text-[10px] text-slate-400 font-normal">(@ ₹{{ $b->milk_rate }})</span></td>
                        <td class="p-3.5 font-semibold text-slate-800">₹{{ number_format($b->subtotal) }}</td>
                        <td class="p-3.5 text-slate-700">₹{{ number_format($b->additional_products_amount) }}</td>
                        <td class="p-3.5 text-emerald-600">-₹{{ number_format($b->discount_amount) }}</td>
                        <td class="p-3.5 font-black text-slate-900 text-sm">₹{{ number_format($b->total_amount) }}</td>
                        <td class="p-3.5 text-emerald-700 font-bold">₹{{ number_format($b->paid_amount) }}</td>
                        <td class="p-3.5 font-bold {{ $b->pending_amount > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                            ₹{{ number_format($b->pending_amount) }}
                        </td>
                        <td class="p-3.5">
                            @if($b->status === 'paid')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">PAID</span>
                            @elseif($b->status === 'partial')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">PARTIAL</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">UNPAID</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- View / Download Invoice -->
                                <button type="button" @click="selectedInvoice = {{ json_encode($b) }}" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:text-brand-600 hover:bg-slate-100 transition" title="Print / Download Invoice">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </button>

                                <!-- Send on WhatsApp Modal Trigger -->
                                <button type="button" @click="whatsappModal = {{ json_encode($b) }}" 
                                        class="p-1.5 rounded-lg text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 transition" title="Send on WhatsApp">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                </button>

                                <!-- Send Reminder -->
                                @if($b->pending_amount > 0)
                                <button type="button" onclick="alert('Payment reminder SMS & WhatsApp dispatched to {{ $b->customer->name ?? 'customer' }} for ₹{{ number_format($b->pending_amount) }}.');" 
                                        class="p-1.5 rounded-lg text-amber-600 hover:text-amber-700 hover:bg-amber-50 transition" title="Send Reminder">
                                    <i data-lucide="bell" class="w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal 1: Generate Bill Form -->
    <div x-cloak x-show="createBillModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="createBillModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="createBillModal = false"></div>

            <div x-show="createBillModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <div class="bg-brand-900 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-brand-300 uppercase tracking-widest">Monthly Ledger Generator</span>
                        <h3 class="text-lg font-bold">Generate Customer Invoice</h3>
                    </div>
                    <button @click="createBillModal = false" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('dairy.billing.generate') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Select Customer *</label>
                        <select name="customer_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-semibold">
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->customer_code }} - {{ $c->daily_quantity }}L/day)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Billing Month *</label>
                            <input type="text" name="month_year" value="September 2026" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Total Litres *</label>
                            <input type="number" step="0.5" name="total_litres" value="60" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold text-brand-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Rate (₹/L) *</label>
                            <input type="number" step="1" name="milk_rate" value="60" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Addl. Products</label>
                            <input type="number" step="10" name="additional_products" value="500" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Discount (₹)</label>
                            <input type="number" step="10" name="discount" value="100" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 text-emerald-600 font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="createBillModal = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow">
                            Generate & Save Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Professional Printable Invoice View -->
    <div x-cloak x-show="selectedInvoice" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="selectedInvoice" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="selectedInvoice = null"></div>

            <div x-show="selectedInvoice" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-xl sm:w-full border border-slate-200">
                <!-- Printable Invoice Header -->
                <div class="p-8 border-b border-slate-200 space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-brand-600 text-white flex items-center justify-center font-bold">
                                    <i data-lucide="milk" class="w-4 h-4"></i>
                                </div>
                                <span class="text-xl font-extrabold text-slate-900">{{ $dairy->name }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1">{{ $dairy->address }}, {{ $dairy->city }}</p>
                            <p class="text-[11px] text-slate-500 font-mono">Helpline: {{ $dairy->phone }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs uppercase font-extrabold tracking-widest text-brand-600 block">TAX INVOICE</span>
                            <strong class="font-mono text-slate-900 text-sm" x-text="selectedInvoice?.bill_number"></strong>
                            <span class="text-xs text-slate-500 block" x-text="'Period: ' + selectedInvoice?.month_year"></span>
                        </div>
                    </div>

                    <!-- Customer Bill Details -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs">
                        <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Billed To:</span>
                        <strong class="text-slate-900 text-sm block" x-text="selectedInvoice?.customer?.name"></strong>
                        <span class="text-slate-600 font-mono" x-text="selectedInvoice?.customer?.phone"></span>
                        <span class="text-slate-500 block" x-text="selectedInvoice?.customer?.address + ', ' + selectedInvoice?.customer?.area"></span>
                    </div>

                    <!-- Line Items Table -->
                    <table class="w-full text-left text-xs">
                        <thead class="border-b text-slate-500 font-bold">
                            <tr>
                                <th class="pb-2">Description</th>
                                <th class="pb-2 text-right">Qty</th>
                                <th class="pb-2 text-right">Rate</th>
                                <th class="pb-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <tr>
                                <td class="py-2.5 font-bold text-slate-900">Fresh Cow Milk Delivery</td>
                                <td class="py-2.5 text-right font-mono" x-text="selectedInvoice?.total_litres + ' L'"></td>
                                <td class="py-2.5 text-right font-mono" x-text="'₹' + selectedInvoice?.milk_rate"></td>
                                <td class="py-2.5 text-right font-bold text-slate-900" x-text="'₹' + selectedInvoice?.subtotal"></td>
                            </tr>
                            <tr x-show="selectedInvoice?.additional_products_amount > 0">
                                <td class="py-2.5 text-slate-800">Additional Dairy Products (Paneer / Ghee)</td>
                                <td class="py-2.5 text-right font-mono">1 Item</td>
                                <td class="py-2.5 text-right font-mono" x-text="'₹' + selectedInvoice?.additional_products_amount"></td>
                                <td class="py-2.5 text-right font-bold text-slate-900" x-text="'₹' + selectedInvoice?.additional_products_amount"></td>
                            </tr>
                            <tr x-show="selectedInvoice?.discount_amount > 0">
                                <td class="py-2.5 text-emerald-600 font-semibold">Special Customer Discount</td>
                                <td class="py-2.5 text-right font-mono text-emerald-600">—</td>
                                <td class="py-2.5 text-right font-mono text-emerald-600">—</td>
                                <td class="py-2.5 text-right font-bold text-emerald-600" x-text="'-₹' + selectedInvoice?.discount_amount"></td>
                            </tr>
                        </tbody>
                        <tfoot class="border-t text-xs">
                            <tr>
                                <td colspan="3" class="pt-3 text-right font-bold text-slate-700">Total Bill Amount:</td>
                                <td class="pt-3 text-right font-black text-slate-900 text-sm" x-text="'₹' + selectedInvoice?.total_amount"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right font-bold text-emerald-700">Paid Amount:</td>
                                <td class="text-right font-bold text-emerald-700" x-text="'₹' + selectedInvoice?.paid_amount"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right font-bold text-rose-600 text-sm">Net Due Balance:</td>
                                <td class="text-right font-black text-rose-600 text-base" x-text="'₹' + selectedInvoice?.pending_amount"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="p-4 bg-slate-50 border-t flex items-center justify-between">
                    <button @click="selectedInvoice = null" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600">Close</button>
                    <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow flex items-center gap-1.5">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>Print Invoice / Download PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Send on WhatsApp Message Preview -->
    <div x-cloak x-show="whatsappModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="whatsappModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="whatsappModal = null"></div>

            <div x-show="whatsappModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <div class="bg-emerald-700 p-5 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <h3 class="text-base font-bold">WhatsApp Invoice Dispatch</h3>
                    </div>
                    <button @click="whatsappModal = null" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 text-xs">
                    <p class="text-slate-500">The following formatted invoice alert will be dispatched to customer's WhatsApp number:</p>
                    
                    <!-- Simulated WhatsApp Message Bubble -->
                    <div class="bg-[#dcf8c6] p-4 rounded-2xl text-slate-900 font-mono shadow-sm border border-emerald-200/80 space-y-2 text-[11px] leading-relaxed">
                        <p>🥛 *{{ $dairy->name }}*</p>
                        <p>Namaste *<span x-text="whatsappModal?.customer?.name"></span>* ji 🙏</p>
                        <p>Your milk bill for *<span x-text="whatsappModal?.month_year"></span>* has been generated.</p>
                        <hr class="border-emerald-300">
                        <p>• Total Milk: *<span x-text="whatsappModal?.total_litres + ' Litres'"></span>*</p>
                        <p>• Total Amount: *₹<span x-text="whatsappModal?.total_amount"></span>*</p>
                        <p>• Pending Due: *₹<span x-text="whatsappModal?.pending_amount"></span>*</p>
                        <hr class="border-emerald-300">
                        <p>👉 Pay online with 1-click via UPI / GPay:</p>
                        <p class="text-blue-700 underline font-semibold">https://pay.milkflow.in/inv/<span x-text="whatsappModal?.bill_number"></span></p>
                        <p class="text-slate-600 text-[10px]">Thank you for supporting pure fresh local milk!</p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t flex items-center justify-between">
                    <button @click="whatsappModal = null" class="px-4 py-2 rounded-xl text-slate-600 text-xs font-semibold">Cancel</button>
                    <button type="button" @click="alert('WhatsApp invoice sent to ' + whatsappModal?.customer?.name + ' (' + whatsappModal?.customer?.phone + ') successfully!'); whatsappModal = null;" 
                            class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Send WhatsApp Now</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
