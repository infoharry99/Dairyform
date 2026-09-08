@extends('layouts.admin')

@section('title', 'Staff & Delivery Team - MilkFlow')
@section('page_title', 'Staff Accounts & Roles')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    {{ $staff->count() }} Team Members
</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Role-Based Access Control (RBAC)</h3>
            <p class="text-xs text-slate-500">Provide controlled logins to Delivery Boys, Accountants, and Shop Managers.</p>
        </div>
        <button onclick="alert('Invite link copied for new staff member.')" class="px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow transition flex items-center gap-1.5">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Add Staff Member
        </button>
    </div>

    <!-- Staff Cards Grid (As Required by Prompt) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($staff as $member)
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-700 font-bold flex items-center justify-center text-sm">
                        {{ substr($member->name, 0, 1) }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                        {{ $member->role === 'delivery_boy' ? 'bg-blue-100 text-blue-800' : ($member->role === 'accountant' ? 'bg-amber-100 text-amber-800' : 'bg-purple-100 text-purple-800') }}">
                        {{ str_replace('_', ' ', $member->role) }}
                    </span>
                </div>

                <h4 class="font-bold text-slate-900 text-base">{{ $member->name }}</h4>
                <p class="text-xs text-slate-500 font-mono mb-2">{{ $member->phone }}</p>
                
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-xs space-y-1 my-3">
                    <span class="text-slate-400 block text-[10px]">Assigned Area:</span>
                    <strong class="text-slate-900">{{ $member->assigned_area }}</strong>
                </div>

                <!-- Granular Permissions Matrix -->
                <div class="space-y-1 text-[11px] text-slate-600">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Access Rights:</span>
                    @foreach($member->permissions ?? ['view_route', 'mark_delivery'] as $perm)
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                        <span>{{ ucwords(str_replace('_', ' ', $perm)) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-emerald-700 font-semibold">Active Login</span>
                <button type="button" onclick="alert('Editing permissions for {{ $member->name }}.');" class="text-brand-600 hover:text-brand-800 font-bold">
                    Edit Rights
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
