@extends('layouts.public')

@section('title', 'Platform Features - MilkFlow Dairy SaaS')

@section('content')
<div class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Capabilities</span>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Comprehensive Dairy Operating System</h1>
        <p class="text-base text-slate-600 mt-4">Discover the high-performance modules engineered specifically for village and urban dairy businesses.</p>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        <!-- Feature 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold">
                    <i data-lucide="sun" class="w-4 h-4"></i> Shift-Based Milk Tracking
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Morning & Evening Shifts with Zero Errors</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Local dairy operations operate on dual shifts. MilkFlow allows independent morning and evening entries with specific rates per customer. Record variations when a customer asks for extra milk or requests a temporary skip.
                </p>
                <ul class="space-y-2 text-xs text-slate-600 font-medium">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Individual Cow, Buffalo, or Mixed milk rate assignment</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> One-click status toggling: Delivered, Skipped, Paused</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Daily summary tally showing exact litres dispatched</li>
                </ul>
            </div>
            <div class="bg-slate-100 p-6 rounded-3xl border border-slate-200 shadow-inner">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-100">
                        <span class="font-bold text-slate-900">Morning Shift Milk Tally</span>
                        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">412 / 486 Litres Dispatched</span>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                            <span class="font-semibold text-slate-800">Scheme 54 Route</span>
                            <span class="text-brand-700 font-bold">142 L • 100% Done</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                            <span class="font-semibold text-slate-800">Vijay Nagar Route</span>
                            <span class="text-brand-700 font-bold">160 L • 100% Done</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                            <span class="font-semibold text-slate-800">Palasia Route</span>
                            <span class="text-amber-700 font-bold">110 L • In Delivery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1 bg-slate-100 p-6 rounded-3xl border border-slate-200 shadow-inner">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <span class="text-xs font-bold text-slate-900">Monthly Bill Preview</span>
                        <span class="text-[11px] font-bold text-brand-600">INV-202609-101</span>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600"><span>Customer:</span><strong class="text-slate-900">Rajesh Sharma</strong></div>
                        <div class="flex justify-between text-slate-600"><span>Cow Milk (58 Litres @ ₹60):</span><span class="font-semibold">₹3,480</span></div>
                        <div class="flex justify-between text-slate-600"><span>Desi Paneer (1 kg):</span><span class="font-semibold">₹500</span></div>
                        <div class="flex justify-between text-emerald-600 font-medium"><span>Festive Discount:</span><span>-₹100</span></div>
                        <div class="pt-2 border-t flex justify-between text-sm font-bold text-slate-900">
                            <span>Total Due:</span>
                            <span class="text-brand-600">₹3,880</span>
                        </div>
                    </div>
                    <button class="w-full py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i> Send Invoice on WhatsApp
                    </button>
                </div>
            </div>
            <div class="order-1 lg:order-2 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold">
                    <i data-lucide="receipt" class="w-4 h-4"></i> Automated Billing
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Instant Month-End Bills with WhatsApp PDF Dispatch</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Say goodbye to spending 3 days every month doing manual calculations on paper. MilkFlow generates accurate bills in seconds including milk, curd, paneer, and ghee orders.
                </p>
                <ul class="space-y-2 text-xs text-slate-600 font-medium">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Seamless product add-ons (Curd, Ghee, Butter, Paneer)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Partial payment and balance carried forward support</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-600"></i> Direct PDF generation and WhatsApp payment reminders</li>
                </ul>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                    <i data-lucide="smartphone" class="w-4 h-4"></i> Customer Self-Service
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Mobile-First App for Customers</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Give your milk customers an elite customer experience. They can log in to view their delivery history, pay via UPI, request delivery pauses when traveling, or request extra milk without calling you at 5 AM.
                </p>
                <div class="pt-2">
                    <a href="{{ route('demo.switch', 'customer') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow transition">
                        <span>Test Customer App</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
            <div class="bg-slate-100 p-6 rounded-3xl border border-slate-200 shadow-inner flex justify-center">
                <!-- Mobile Mockup Frame -->
                <div class="w-72 bg-slate-900 p-3 rounded-[36px] shadow-2xl border-4 border-slate-800">
                    <div class="bg-white rounded-[28px] overflow-hidden p-4 space-y-4">
                        <div class="flex items-center justify-between text-xs pb-2 border-b">
                            <span class="font-bold text-slate-800">Good Morning, Rajesh 👋</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="bg-brand-50 p-3 rounded-xl border border-brand-100">
                            <div class="text-[10px] text-brand-700 font-semibold uppercase">Today's Milk</div>
                            <div class="text-xl font-black text-brand-900">2.0 Litres</div>
                            <div class="text-[10px] text-emerald-700 font-bold mt-1">✓ Delivered at 06:45 AM</div>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500">Pending Bill:</span>
                                <span class="font-bold text-rose-600">₹1,480</span>
                            </div>
                            <button class="w-full mt-2 py-1.5 rounded-lg bg-emerald-600 text-white text-[11px] font-bold">
                                Pay via UPI
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
