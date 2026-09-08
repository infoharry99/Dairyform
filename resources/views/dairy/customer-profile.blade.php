@extends('layouts.admin')

@section('title', $customer->name . ' - Customer 360 Profile')
@section('page_title', 'Customer Profile: ' . $customer->name)

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    {{ $customer->customer_code }}
</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Profile Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-600 text-white font-black text-2xl flex items-center justify-center shadow-lg shadow-brand-600/20">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-black text-slate-900">{{ $customer->name }}</h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $customer->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 flex items-center gap-3">
                    <span class="font-mono text-slate-700 font-semibold">{{ $customer->phone }}</span>
                    <span>• Route: <strong>{{ $customer->area }}</strong></span>
                    <span>• Since: {{ $customer->start_date->format('M Y') }}</span>
                </p>
                @if($customer->notes)
                <p class="text-[11px] text-brand-700 bg-brand-50 px-2 py-0.5 rounded inline-block">
                    Note: {{ $customer->notes }}
                </p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3 self-stretch md:self-auto justify-end">
            <!-- Impersonate Customer App Trigger -->
            <a href="{{ route('demo.switch', 'customer') }}" class="px-4 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 text-xs font-bold border border-amber-200 shadow-sm transition flex items-center gap-1.5">
                <i data-lucide="smartphone" class="w-4 h-4 text-amber-600"></i>
                <span>Open in Customer App</span>
            </a>
            <form action="{{ route('dairy.customers.toggle-status', $customer->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">
                    {{ $customer->status === 'active' ? 'Pause Delivery' : 'Resume Delivery' }}
                </button>
            </form>
        </div>
    </div>

    <!-- 4 Metrics for Customer -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 block mb-1">Daily Preference</span>
            <div class="text-xl font-black text-slate-900">{{ $customer->daily_quantity }} Litres</div>
            <span class="text-[10px] text-brand-600 font-semibold uppercase">{{ $customer->milk_type }} Milk ({{ $customer->delivery_time }})</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 block mb-1">Contract Rate</span>
            <div class="text-xl font-black text-slate-900">₹{{ $customer->rate_per_litre }} <span class="text-xs font-normal text-slate-400">/Litre</span></div>
            <span class="text-[10px] text-slate-400">Daily cost: ₹{{ $customer->daily_quantity * $customer->rate_per_litre }}</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 block mb-1">Current Month Delivered</span>
            <div class="text-xl font-black text-emerald-600">58 Litres</div>
            <span class="text-[10px] text-slate-400">29 days completed</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-500 block mb-1">Total Outstanding Dues</span>
            <div class="text-xl font-black text-rose-600">₹1,480</div>
            <span class="text-[10px] text-rose-500 font-semibold">September Bill Due</span>
        </div>
    </div>

    <!-- Consumption History & Billing Log -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Daily Milk Log -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Recent Daily Milk Logs</h3>
                <span class="text-xs text-slate-400">Last 7 Deliveries</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 font-bold border-b">
                        <tr>
                            <th class="p-2.5">Date</th>
                            <th class="p-2.5">Shift</th>
                            <th class="p-2.5">Quantity</th>
                            <th class="p-2.5">Amount</th>
                            <th class="p-2.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($customer->milkRecords->take(7) as $r)
                        <tr>
                            <td class="p-2.5 font-semibold text-slate-900">{{ $r->date->format('d M Y') }}</td>
                            <td class="p-2.5 capitalize text-slate-600">{{ $r->shift }}</td>
                            <td class="p-2.5 font-bold">{{ $r->quantity }} L</td>
                            <td class="p-2.5">₹{{ $r->amount }}</td>
                            <td class="p-2.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $r->status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Bills & Invoices -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Invoices & Billing History</h3>
                <span class="text-xs text-slate-400">All Generated Bills</span>
            </div>
            <div class="space-y-3">
                @foreach($customer->bills as $b)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                    <div>
                        <span class="font-mono text-[11px] text-slate-500 font-bold block">{{ $b->bill_number }}</span>
                        <strong class="text-slate-900 text-sm">{{ $b->month_year }}</strong>
                        <div class="text-[10px] text-slate-500 mt-0.5">
                            {{ $b->total_litres }} Litres • Paid: ₹{{ number_format($b->paid_amount) }}
                        </div>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="text-sm font-black text-slate-900 block">₹{{ number_format($b->total_amount) }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $b->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ strtoupper($b->status) }} (Due: ₹{{ number_format($b->pending_amount) }})
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
