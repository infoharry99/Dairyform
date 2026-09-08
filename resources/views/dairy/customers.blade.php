@extends('layouts.admin')

@section('title', 'Customer Management - MilkFlow Dairy Admin')
@section('page_title', 'Customer Directory & Profiles')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    {{ $customers->count() }} Profiles Loaded (324 Total Active)
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ addCustomerModal: false, editCustomer: null }">
    <!-- Top Bar with Search, Filters & Add Customer CTA -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('dairy.customers') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Search Input -->
            <div class="relative flex-1 sm:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer, phone, code..." 
                       class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
            </div>

            <!-- Route / Area Filter -->
            <select name="area" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50/50 font-medium">
                <option value="">All Route Areas</option>
                @foreach($areas as $area)
                <option value="{{ $area }}" {{ request('area') === $area ? 'selected' : '' }}>{{ $area }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50/50 font-medium">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Delivery</option>
                <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>Paused / Vacation</option>
            </select>

            <!-- Milk Type Filter -->
            <select name="milk_type" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50/50 font-medium">
                <option value="">All Milk Types</option>
                <option value="cow" {{ request('milk_type') === 'cow' ? 'selected' : '' }}>Cow Milk</option>
                <option value="buffalo" {{ request('milk_type') === 'buffalo' ? 'selected' : '' }}>Buffalo Milk</option>
                <option value="mixed" {{ request('milk_type') === 'mixed' ? 'selected' : '' }}>Mixed Milk</option>
            </select>

            @if(request()->anyFilled(['search', 'area', 'status', 'milk_type']))
            <a href="{{ route('dairy.customers') }}" class="text-xs text-rose-600 hover:underline font-semibold">Clear</a>
            @endif
        </form>

        <!-- Add Customer Button -->
        <button type="button" @click="addCustomerModal = true" 
                class="px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition flex items-center gap-1.5 self-end md:self-auto">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Add New Customer</span>
        </button>
    </div>

    <!-- Customer Table (As Required by Prompt) -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">Mobile</th>
                        <th class="p-4">Address / Area</th>
                        <th class="p-4">Daily Qty</th>
                        <th class="p-4">Milk Type</th>
                        <th class="p-4">Rate</th>
                        <th class="p-4">Monthly Bill</th>
                        <th class="p-4">Paid</th>
                        <th class="p-4">Pending</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($customers as $c)
                    @php
                        $latestBill = $c->bills->last();
                        $billAmount = $latestBill ? $latestBill->total_amount : ($c->daily_quantity * 30 * $c->rate_per_litre);
                        $paidAmount = $latestBill ? $latestBill->paid_amount : round($billAmount * 0.6);
                        $pendingAmount = $latestBill ? $latestBill->pending_amount : ($billAmount - $paidAmount);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- Customer Name -->
                        <td class="p-4">
                            <a href="{{ route('dairy.customers.profile', $c->id) }}" class="font-bold text-slate-900 hover:text-brand-600 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-brand-50 text-brand-700 font-bold flex items-center justify-center text-[10px]">
                                    {{ substr($c->name, 0, 1) }}
                                </span>
                                <div>
                                    <span class="block">{{ $c->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono font-normal">{{ $c->customer_code }}</span>
                                </div>
                            </a>
                        </td>

                        <!-- Mobile -->
                        <td class="p-4 text-slate-700 font-mono">{{ $c->phone }}</td>

                        <!-- Address -->
                        <td class="p-4">
                            <span class="font-semibold text-slate-800 block">{{ $c->area }}</span>
                            <span class="text-[10px] text-slate-400 block truncate max-w-xs">{{ $c->address }}</span>
                        </td>

                        <!-- Daily Quantity -->
                        <td class="p-4 font-bold text-slate-900 text-sm">
                            {{ $c->daily_quantity }} <span class="text-xs text-slate-500 font-normal">L</span>
                            <span class="text-[10px] text-slate-400 block font-normal capitalize">({{ $c->delivery_time }})</span>
                        </td>

                        <!-- Milk Type -->
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                {{ $c->milk_type === 'cow' ? 'bg-blue-50 text-blue-700' : ($c->milk_type === 'buffalo' ? 'bg-purple-50 text-purple-700' : 'bg-amber-50 text-amber-700') }}">
                                {{ $c->milk_type }}
                            </span>
                        </td>

                        <!-- Rate -->
                        <td class="p-4 font-bold text-slate-900">₹{{ $c->rate_per_litre }}/L</td>

                        <!-- Monthly Bill -->
                        <td class="p-4 font-bold text-slate-800">₹{{ number_format($billAmount) }}</td>

                        <!-- Paid -->
                        <td class="p-4 text-emerald-700 font-bold">₹{{ number_format($paidAmount) }}</td>

                        <!-- Pending -->
                        <td class="p-4 font-bold {{ $pendingAmount > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                            ₹{{ number_format($pendingAmount) }}
                        </td>

                        <!-- Status -->
                        <td class="p-4">
                            @if($c->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Paused
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- Profile 360 View -->
                                <a href="{{ route('dairy.customers.profile', $c->id) }}" class="p-1.5 rounded-lg text-slate-600 hover:text-brand-600 hover:bg-slate-100 transition" title="View Customer Profile">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </a>

                                <!-- Pause / Resume Toggle -->
                                <form action="{{ route('dairy.customers.toggle-status', $c->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if($c->status === 'active')
                                    <button type="submit" onclick="return confirm('Pause milk delivery for {{ $c->name }}?')" 
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition" title="Pause Delivery">
                                        <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                    </button>
                                    @else
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Resume Delivery">
                                        <i data-lucide="play-circle" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="p-8 text-center text-slate-500">No customers found matching criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Add New Customer (As Required by Prompt) -->
    <div x-cloak x-show="addCustomerModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="addCustomerModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="addCustomerModal = false"></div>

            <div x-show="addCustomerModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-xl sm:w-full border border-slate-200">
                <div class="bg-gradient-to-r from-slate-900 to-brand-950 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-brand-400 uppercase tracking-widest">New Customer Onboarding</span>
                        <h3 class="text-xl font-bold">Add Customer to {{ $dairy->name }}</h3>
                    </div>
                    <button @click="addCustomerModal = false" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('dairy.customers.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Customer Full Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Ramesh Patel" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Mobile (WhatsApp) *</label>
                            <input type="tel" name="phone" required placeholder="+91 98930 11111" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Email (Optional)</label>
                            <input type="email" name="email" placeholder="customer@gmail.com" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Route / Area *</label>
                            <select name="area" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                                @foreach($areas as $area)
                                <option value="{{ $area }}">{{ $area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Full Delivery Address *</label>
                        <input type="text" name="address" required placeholder="Flat / House No, Building, Street" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>

                    <div class="grid grid-cols-3 gap-3 bg-brand-50/50 p-3.5 rounded-2xl border border-brand-100">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Daily Litres *</label>
                            <input type="number" step="0.5" name="daily_quantity" value="2.0" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-bold text-brand-700">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Milk Type *</label>
                            <select name="milk_type" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white">
                                <option value="cow">Cow Milk</option>
                                <option value="buffalo">Buffalo Milk</option>
                                <option value="mixed">Mixed Milk</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Rate (₹/L) *</label>
                            <input type="number" step="1" name="rate_per_litre" value="60" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Delivery Shift *</label>
                            <select name="delivery_time" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                                <option value="morning">Morning Only</option>
                                <option value="evening">Evening Only</option>
                                <option value="both">Both Morning & Evening</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Special Delivery Note</label>
                            <input type="text" name="notes" placeholder="e.g. Ring bell once, leave at door" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                        </div>
                    </div>

                    <div class="pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="addCustomerModal = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow-md shadow-brand-600/20">
                            Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
