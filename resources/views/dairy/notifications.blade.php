@extends('layouts.admin')

@section('title', 'Dairy Notifications - MilkFlow')
@section('page_title', 'Dairy Notification Center')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Operational Alerts & Updates</h3>
            <p class="text-xs text-slate-500">Live notifications regarding delivery completions, payments, and billing events.</p>
        </div>
        <button onclick="alert('All notifications marked as read.');" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
            Mark all read
        </button>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 divide-y divide-slate-100">
        @forelse($notifications as $n)
        <div class="py-4 flex items-start gap-4">
            <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                <i data-lucide="bell" class="w-4 h-4"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900">{{ $n->title }}</h4>
                    <span class="text-[10px] text-slate-400">{{ $n->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-slate-600 mt-0.5">{{ $n->message }}</p>
                <span class="inline-block mt-2 px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[10px] capitalize">{{ $n->type }}</span>
            </div>
        </div>
        @empty
        <p class="py-8 text-center text-xs text-slate-500">No unread notifications for this dairy.</p>
        @endforelse
    </div>
</div>
@endsection
