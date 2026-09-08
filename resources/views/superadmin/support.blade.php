@extends('layouts.admin')

@section('title', 'Platform Support Desk - Super Admin')
@section('page_title', 'Support Tickets & Inquiries')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Multi-Tenant Helpdesk</h3>
            <p class="text-xs text-slate-500">Tickets raised by dairy shop owners and customers</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-3">Ticket #</th>
                        <th class="p-3">Dairy Shop</th>
                        <th class="p-3">Customer / Raised By</th>
                        <th class="p-3">Subject</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($tickets as $t)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-3 font-mono font-bold text-indigo-700">{{ $t->ticket_number }}</td>
                        <td class="p-3 font-semibold text-slate-900">{{ $t->dairy->name ?? 'Dairy' }}</td>
                        <td class="p-3 text-slate-700">{{ $t->customer->name ?? 'Customer' }}</td>
                        <td class="p-3">
                            <strong class="text-slate-900 block">{{ $t->subject }}</strong>
                            <span class="text-[11px] text-slate-500 line-clamp-1">{{ $t->message }}</span>
                        </td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $t->status === 'resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <button onclick="alert('Ticket Response: {{ addslashes($t->reply ?? 'No reply yet. Status: Open') }}')" class="text-xs font-bold text-indigo-600 hover:underline">
                                View Thread
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500">No active support tickets.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
