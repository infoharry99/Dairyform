@extends('layouts.admin')

@section('title', 'Shop Settings - MilkFlow')
@section('page_title', 'Dairy Shop Settings')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="border-b pb-4">
            <h3 class="text-sm font-bold text-slate-900">Dairy Profile & Business Information</h3>
            <p class="text-xs text-slate-500">Details printed on customer invoices and WhatsApp PDF bills.</p>
        </div>

        <form action="{{ route('dairy.settings') }}" method="GET" class="space-y-4 text-xs">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Dairy Shop Name</label>
                    <input type="text" value="{{ $dairy->name }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Owner Name</label>
                    <input type="text" value="{{ $dairy->owner_name }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Owner Contact (WhatsApp)</label>
                    <input type="text" value="{{ $dairy->phone }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">City Hub</label>
                    <input type="text" value="{{ $dairy->city }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Shop Address</label>
                <textarea rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">{{ $dairy->address }}</textarea>
            </div>

            <div class="border-t pt-4">
                <h4 class="font-bold text-slate-900 mb-2">Shift Dispatch Timings</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-500 mb-1">Morning Shift Starts</label>
                        <input type="time" value="05:00" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-500 mb-1">Evening Shift Starts</label>
                        <input type="time" value="17:00" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="button" onclick="alert('Shop settings saved successfully.');" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
