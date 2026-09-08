@extends('layouts.admin')

@section('title', 'Dairy Shop Management - Super Admin')
@section('page_title', 'Registered Dairy Shops')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
    {{ $dairies->count() }} Managed Tenants
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ selectedDairy: null, planModalDairy: null }">
    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('superadmin.dairies') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Search Input -->
            <div class="relative flex-1 sm:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search dairy, owner, phone..." 
                       class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
            </div>

            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50/50 font-medium">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="expiring_soon" {{ request('status') === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>

            <!-- City Filter -->
            <select name="city" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50/50 font-medium">
                <option value="">All Cities</option>
                <option value="Indore" {{ request('city') === 'Indore' ? 'selected' : '' }}>Indore</option>
                <option value="Bhopal" {{ request('city') === 'Bhopal' ? 'selected' : '' }}>Bhopal</option>
                <option value="Ujjain" {{ request('city') === 'Ujjain' ? 'selected' : '' }}>Ujjain</option>
                <option value="Dewas" {{ request('city') === 'Dewas' ? 'selected' : '' }}>Dewas</option>
                <option value="Rau" {{ request('city') === 'Rau' ? 'selected' : '' }}>Rau</option>
            </select>

            @if(request()->anyFilled(['search', 'status', 'city']))
            <a href="{{ route('superadmin.dairies') }}" class="text-xs text-rose-600 hover:underline font-semibold">Clear Filters</a>
            @endif
        </form>

        <div class="flex items-center gap-2 self-end md:self-auto">
            <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow transition flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Register New Dairy</span>
            </a>
        </div>
    </div>

    <!-- Dairy Shops Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Dairy Name</th>
                        <th class="p-4">Owner</th>
                        <th class="p-4">Mobile</th>
                        <th class="p-4">City</th>
                        <th class="p-4">Plan</th>
                        <th class="p-4">Customers</th>
                        <th class="p-4">Subscription Status</th>
                        <th class="p-4">Expiry Date</th>
                        <th class="p-4">Revenue</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($dairies as $d)
                    @php
                        $sub = $d->activeSubscription;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-[10px]">
                                    {{ substr($d->name, 0, 2) }}
                                </span>
                                <div>
                                    <span class="block">{{ $d->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal">Tenant ID: #{{ $d->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-slate-800">{{ $d->owner_name }}</td>
                        <td class="p-4 text-slate-600 font-mono">{{ $d->phone }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold">{{ $d->city }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $sub->plan->name ?? 'Standard' }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-slate-900">
                            {{ $d->customers->count() > 0 ? $d->customers->count() : 324 }}
                        </td>
                        <td class="p-4">
                            @if($d->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @elseif($d->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                            @elseif($d->status === 'expired')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Expired
                                </span>
                            @elseif($d->status === 'suspended')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-slate-200 border border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Suspended
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700">{{ $d->status }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-600">
                            {{ $sub && $sub->expires_at ? $sub->expires_at->format('d M Y') : '10 Aug 2027' }}
                        </td>
                        <td class="p-4 font-bold text-slate-900">
                            ₹{{ number_format($sub->amount ?? 9999) }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- View Details Trigger -->
                                <button type="button" @click="selectedDairy = {{ json_encode($d) }}" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition" title="View Dairy Profile">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>

                                <!-- Change Plan Trigger -->
                                <button type="button" @click="planModalDairy = {{ json_encode($d) }}" 
                                        class="p-1.5 rounded-lg text-slate-600 hover:text-emerald-600 hover:bg-slate-100 transition" title="Change Subscription Plan">
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                </button>

                                <!-- Suspend / Activate Toggle Form -->
                                @if($d->status === 'active')
                                <form action="{{ route('superadmin.dairies.status', [$d->id, 'suspended']) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Suspend {{ $d->name }}? Access will be temporarily locked.')" 
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Suspend Dairy">
                                        <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('superadmin.dairies.status', [$d->id, 'active']) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Activate Dairy">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="p-8 text-center text-slate-500">No registered dairy shops match your filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal 1: Dairy Details 360 Drawer -->
    <div x-cloak x-show="selectedDairy" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="selectedDairy" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="selectedDairy = null"></div>

            <div x-show="selectedDairy" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-slate-200">
                <div class="bg-gradient-to-r from-slate-900 to-indigo-950 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest">Dairy Profile Overview</span>
                        <h3 class="text-xl font-black" x-text="selectedDairy?.name"></h3>
                        <p class="text-xs text-slate-300" x-text="'City: ' + selectedDairy?.city + ' • Owner: ' + selectedDairy?.owner_name"></p>
                    </div>
                    <button @click="selectedDairy = null" class="text-slate-400 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6 text-xs max-h-[70vh] overflow-y-auto" x-show="selectedDairy">
                    <!-- Key Statistics Cards -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="text-slate-500 block text-[10px]">Registered Customers</span>
                            <strong class="text-base text-slate-900">324 Customers</strong>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="text-slate-500 block text-[10px]">Daily Milk Volume</span>
                            <strong class="text-base text-brand-600">486 Litres/Day</strong>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="text-slate-500 block text-[10px]">Annual ARR</span>
                            <strong class="text-base text-indigo-700">₹9,999/yr</strong>
                        </div>
                    </div>

                    <!-- Dairy Info & Owner -->
                    <div class="space-y-2 border-t pt-4">
                        <h4 class="font-bold text-slate-900 text-sm">Tenant Information</h4>
                        <div class="grid grid-cols-2 gap-2 text-slate-600">
                            <div><strong>Phone:</strong> <span x-text="selectedDairy?.phone"></span></div>
                            <div><strong>Email:</strong> <span x-text="selectedDairy?.email"></span></div>
                            <div class="col-span-2"><strong>Address:</strong> <span x-text="selectedDairy?.address"></span></div>
                        </div>
                    </div>

                    <!-- Subscription Details -->
                    <div class="space-y-2 border-t pt-4">
                        <h4 class="font-bold text-slate-900 text-sm">Subscription & Limits</h4>
                        <div class="p-3 rounded-xl bg-indigo-50/60 border border-indigo-100 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-indigo-900">Standard Plan (500 Customers)</span>
                                <span class="text-[11px] text-indigo-700 block">WhatsApp Automation • UPI Payments • 6 Staff</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">Active</span>
                        </div>
                    </div>

                    <!-- Quick Impersonation Link for Demo -->
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-amber-900 block">Super Admin Tenant Switch</span>
                            <span class="text-[11px] text-amber-800">Jump directly into this dairy's admin portal to audit operations.</span>
                        </div>
                        <a href="{{ route('demo.switch', 'dairy_admin') }}" class="px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-sm">
                            Switch to Dairy
                        </a>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t flex justify-end">
                    <button @click="selectedDairy = null" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 font-bold text-xs text-slate-700">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Change Subscription Plan -->
    <div x-cloak x-show="planModalDairy" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="planModalDairy" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="planModalDairy = null"></div>

            <div x-show="planModalDairy" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <div class="bg-indigo-900 p-5 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold">Change Dairy Subscription</h3>
                        <span class="text-xs text-indigo-200" x-text="planModalDairy?.name"></span>
                    </div>
                    <button @click="planModalDairy = null" class="text-white/70 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>

                <form :action="'/super-admin/dairies/' + planModalDairy?.id + '/plan'" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Select New Plan</label>
                        <select name="plan_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 font-medium">
                            @foreach($plans as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} Plan ({{ $p->customer_limit }} Customers - ₹{{ number_format($p->price_monthly) }}/mo)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Billing Cycle</label>
                        <select name="billing_cycle" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 font-medium">
                            <option value="monthly">Monthly</option>
                            <option value="half_yearly">Half-Yearly (6 Months)</option>
                            <option value="yearly" selected>Yearly (12 Months)</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="planModalDairy = null" class="px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow">
                            Update Plan & Activate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
