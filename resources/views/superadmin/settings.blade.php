@extends('layouts.admin')

@section('title', 'Platform Settings - Super Admin')
@section('page_title', 'SaaS Platform Configuration')

@section('content')
<div class="space-y-6" x-data="{ tab: 'general' }">
    <!-- Tabs Navigation -->
    <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm flex flex-wrap gap-2 text-xs font-bold">
        <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition">
            Platform Profile
        </button>
        <button @click="tab = 'subscription'" :class="tab === 'subscription' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition">
            Subscription Settings
        </button>
        <button @click="tab = 'payment'" :class="tab === 'payment' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition">
            Payment Gateways
        </button>
        <button @click="tab = 'whatsapp'" :class="tab === 'whatsapp' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition">
            WhatsApp API
        </button>
        <button @click="tab = 'tax'" :class="tab === 'tax' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition">
            GST & Tax Settings
        </button>
    </div>

    <!-- Tab 1: Platform Profile -->
    <div x-show="tab === 'general'" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 border-b pb-2">Global SaaS Branding</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Platform Brand Name</label>
                <input type="text" value="MilkFlow" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Marketing Tagline</label>
                <input type="text" value="Smart Dairy Management for Every Dairy" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Support Email</label>
                <input type="email" value="support@milkflow.demo" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Helpline Phone</label>
                <input type="text" value="+91 98260 00001" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
        </div>
        <button type="button" onclick="alert('Platform profile saved successfully.')" class="mt-2 px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow">
            Save Platform Profile
        </button>
    </div>

    <!-- Tab 2: Subscription Settings -->
    <div x-show="tab === 'subscription'" x-cloak class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 border-b pb-2">Subscription & Trial Rules</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Free Trial Duration</label>
                <input type="text" value="14 Days" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Grace Period on Expiry</label>
                <input type="text" value="3 Days" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Auto-Suspension Behavior</label>
                <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
                    <option>Show Expiry Banner (Allow Read-Only)</option>
                    <option>Strict Gate (Block All Operations)</option>
                </select>
            </div>
        </div>
        <button type="button" onclick="alert('Subscription rules updated.')" class="mt-2 px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow">
            Update Subscription Rules
        </button>
    </div>

    <!-- Tab 3: Payment Settings -->
    <div x-show="tab === 'payment'" x-cloak class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 border-b pb-2">Payment Gateway Configurations</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Razorpay / UPI Merchant Key</label>
                <input type="password" value="rzp_live_92847104928" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Platform UPI VPA ID</label>
                <input type="text" value="milkflow.saas@okhdfcbank" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
            </div>
        </div>
        <button type="button" onclick="alert('Gateway settings saved.')" class="mt-2 px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow">
            Save Gateway Settings
        </button>
    </div>

    <!-- Tab 4: WhatsApp API -->
    <div x-show="tab === 'whatsapp'" x-cloak class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 border-b pb-2">WhatsApp Business Cloud API</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Meta WhatsApp Phone Number ID</label>
                <input type="text" value="1092847102948" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Permanent Access Token</label>
                <input type="password" value="EAAB0294829104829471928" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
            </div>
        </div>
        <button type="button" onclick="alert('WhatsApp connection tested: OK!')" class="mt-2 px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow flex items-center gap-1.5">
            <i data-lucide="check" class="w-4 h-4"></i> Test WhatsApp Connection
        </button>
    </div>

    <!-- Tab 5: GST & Tax -->
    <div x-show="tab === 'tax'" x-cloak class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 border-b pb-2">GST & Invoicing Compliance</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">GSTIN Number</label>
                <input type="text" value="23AAACM1920L1Z4" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50 font-mono">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Software SaaS GST Rate (%)</label>
                <input type="text" value="18% (9% CGST + 9% SGST)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50/50">
            </div>
        </div>
        <button type="button" onclick="alert('Tax compliance settings saved.')" class="mt-2 px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow">
            Save Tax Configurations
        </button>
    </div>
</div>
@endsection
