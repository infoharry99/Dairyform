@extends('layouts.admin')

@section('title', 'Today\'s Milk Recording - MilkFlow')
@section('page_title', 'Daily Milk Recording Desk')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    Shift: {{ ucfirst($shift) }} • {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- 4 Summary Counter Cards (As Required by Prompt) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Customers (324) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 font-semibold block mb-1">Total Customers</span>
            <div class="text-2xl font-black text-slate-900">{{ $summary['total_customers'] }}</div>
            <span class="text-[11px] text-slate-400">All routes active</span>
        </div>

        <!-- Total Quantity (486 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 font-semibold block mb-1">Total Quantity</span>
            <div class="text-2xl font-black text-brand-700">{{ $summary['total_quantity'] }} <span class="text-xs text-slate-500 font-normal">Litres</span></div>
            <span class="text-[11px] text-brand-600 font-semibold">Morning + Evening Shift</span>
        </div>

        <!-- Delivered (412 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 font-semibold block mb-1">Delivered So Far</span>
            <div class="text-2xl font-black text-emerald-600">{{ $summary['delivered'] }} <span class="text-xs text-slate-500 font-normal">Litres</span></div>
            <span class="text-[11px] text-emerald-700 font-bold">85% Completed</span>
        </div>

        <!-- Pending (74 L) -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 font-semibold block mb-1">Pending Milk</span>
            <div class="text-2xl font-black text-amber-600">{{ $summary['pending'] }} <span class="text-xs text-slate-500 font-normal">Litres</span></div>
            <span class="text-[11px] text-amber-700 font-bold">Palasia Evening Route</span>
        </div>
    </div>

    <!-- Date Selector & Shift Tabs -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Shift Selector Tabs -->
        <div class="inline-flex p-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold w-full sm:w-auto">
            <a href="{{ route('dairy.milk', ['shift' => 'morning', 'date' => $date]) }}" 
               class="flex-1 sm:flex-initial px-5 py-2 rounded-lg transition flex items-center justify-center gap-1.5 {{ $shift === 'morning' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i data-lucide="sun" class="w-4 h-4 text-amber-500"></i>
                <span>Morning Shift (05:00 - 08:30 AM)</span>
            </a>
            <a href="{{ route('dairy.milk', ['shift' => 'evening', 'date' => $date]) }}" 
               class="flex-1 sm:flex-initial px-5 py-2 rounded-lg transition flex items-center justify-center gap-1.5 {{ $shift === 'evening' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i data-lucide="moon" class="w-4 h-4 text-indigo-500"></i>
                <span>Evening Shift (05:00 - 07:30 PM)</span>
            </a>
        </div>

        <!-- Date Selector -->
        <form action="{{ route('dairy.milk') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="shift" value="{{ $shift }}">
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" 
                   class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 bg-slate-50/50 focus:ring-2 focus:ring-brand-500">
        </form>
    </div>

    <!-- Milk Entries Table with Inline Quantity & Status Editing -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Active Delivery Entries ({{ ucfirst($shift) }})</h3>
                <p class="text-xs text-slate-500">Modify daily quantity or toggle delivery status. Changes calculate bill subtotal immediately.</p>
            </div>
            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-lg">Auto-Saved</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3.5">Customer</th>
                        <th class="p-3.5">Route Area</th>
                        <th class="p-3.5">Quantity (L)</th>
                        <th class="p-3.5">Milk Type</th>
                        <th class="p-3.5">Rate / L</th>
                        <th class="p-3.5">Daily Amount</th>
                        <th class="p-3.5">Delivery Status</th>
                        <th class="p-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($records as $rec)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- Customer -->
                        <td class="p-3.5">
                            <strong class="text-slate-900 block font-bold">{{ $rec->customer->name ?? 'Customer' }}</strong>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $rec->customer->customer_code ?? '' }} • {{ $rec->customer->phone ?? '' }}</span>
                        </td>

                        <!-- Area -->
                        <td class="p-3.5 font-semibold text-slate-700">{{ $rec->customer->area ?? 'General' }}</td>

                        <!-- Quantity Editing Form -->
                        <td class="p-3.5" x-data="{ editing: false, qty: {{ $rec->quantity }} }">
                            <form action="{{ route('dairy.milk.update', $rec->id) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                <input type="number" step="0.5" name="quantity" x-model="qty" 
                                       class="w-16 px-2 py-1 rounded-lg border border-slate-300 font-bold text-slate-900 text-center bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-500">
                                <span class="text-slate-400 font-normal">L</span>
                                <button type="submit" class="p-1 rounded bg-brand-50 hover:bg-brand-100 text-brand-700" title="Save Quantity">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </td>

                        <!-- Milk Type -->
                        <td class="p-3.5">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                {{ $rec->milk_type === 'cow' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ $rec->milk_type }}
                            </span>
                        </td>

                        <!-- Rate -->
                        <td class="p-3.5 font-semibold text-slate-800">₹{{ $rec->rate }}/L</td>

                        <!-- Amount -->
                        <td class="p-3.5 font-bold text-slate-900 text-sm">₹{{ number_format($rec->amount) }}</td>

                        <!-- Delivery Status Toggle -->
                        <td class="p-3.5">
                            <form action="{{ route('dairy.milk.update', $rec->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" 
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold border 
                                        {{ $rec->status === 'delivered' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : '' }}
                                        {{ $rec->status === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-200' : '' }}
                                        {{ $rec->status === 'skipped' ? 'bg-slate-100 text-slate-700 border-slate-200' : '' }}
                                        {{ $rec->status === 'paused' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}">
                                    <option value="delivered" {{ $rec->status === 'delivered' ? 'selected' : '' }}>Delivered ✓</option>
                                    <option value="pending" {{ $rec->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="skipped" {{ $rec->status === 'skipped' ? 'selected' : '' }}>Skipped</option>
                                    <option value="paused" {{ $rec->status === 'paused' ? 'selected' : '' }}>Paused</option>
                                </select>
                            </form>
                        </td>

                        <td class="p-3.5 text-right">
                            <span class="text-[10px] text-slate-400 font-medium">By {{ $rec->recorded_by ?? 'Suresh' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-500">No milk entries found for this shift.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
