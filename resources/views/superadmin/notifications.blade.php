@extends('layouts.admin')

@section('title', 'Platform Notifications - Super Admin')
@section('page_title', 'Platform Notification Center')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-900">System Broadcasts & Event Alerts</h3>
            <p class="text-xs text-slate-500">Real-time alerts triggered across multi-tenant events</p>
        </div>
        <button onclick="alert('Marked all notifications as read.')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
            Mark all read
        </button>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 divide-y divide-slate-100">
        @forelse($notifications as $n)
        <div class="py-4 flex items-start gap-4">
            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="bell" class="w-4 h-4"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900">{{ $n->title }}</h4>
                    <span class="text-[10px] text-slate-400">{{ $n->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-slate-600 mt-0.5">{{ $n->message }}</p>
                <div class="mt-2 flex items-center gap-2 text-[10px]">
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium capitalize">{{ $n->type }}</span>
                    @if($n->dairy_id)
                    <span class="text-slate-400">• Tenant #{{ $n->dairy_id }}</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="py-8 text-center text-xs text-slate-500">No unread notifications.</p>
        @endforelse
    </div>
</div>
@endsection
