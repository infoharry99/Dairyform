@extends('layouts.base')

@section('title', 'Register Dairy - MilkFlow SaaS Platform')

@section('layout_content')
<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8" x-data="{
    step: 1,
    selectedPlan: {{ request('plan', 2) }},
    billingCycle: 'monthly',
    dairyName: '',
    ownerName: '',
    mobile: '',
    email: '',
    city: 'Indore',
    address: '',
    password: 'password',
    getPlanPrice() {
        if (this.selectedPlan == 1) return this.billingCycle === 'yearly' ? 4999 : (this.billingCycle === 'half_yearly' ? 2699 : 499);
        if (this.selectedPlan == 2) return this.billingCycle === 'yearly' ? 9999 : (this.billingCycle === 'half_yearly' ? 5399 : 999);
        return this.billingCycle === 'yearly' ? 19999 : (this.billingCycle === 'half_yearly' ? 10799 : 1999);
    }
}">
    <div class="max-w-3xl mx-auto">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-600/20">
                    <i data-lucide="milk" class="w-6 h-6"></i>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-black text-slate-900 tracking-tight">Milk<span class="text-brand-600">Flow</span></span>
                    <span class="block text-[10px] text-slate-500 font-semibold tracking-wider uppercase">Dairy Onboarding</span>
                </div>
            </a>
            <h1 class="mt-4 text-3xl font-extrabold text-slate-900">Start Your Digital Dairy</h1>
            <p class="text-xs text-slate-500 mt-1">Set up your isolated tenant dashboard in 3 quick steps.</p>
        </div>

        <!-- Stepper Progress Bar -->
        <div class="mb-8 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="grid grid-cols-3 gap-2 text-center text-xs font-bold">
                <div :class="step >= 1 ? 'text-brand-600' : 'text-slate-400'" class="flex items-center justify-center gap-2">
                    <span :class="step >= 1 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-500'" class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]">1</span>
                    <span>Dairy Info</span>
                </div>
                <div :class="step >= 2 ? 'text-brand-600' : 'text-slate-400'" class="flex items-center justify-center gap-2">
                    <span :class="step >= 2 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-500'" class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]">2</span>
                    <span>Select Plan</span>
                </div>
                <div :class="step >= 3 ? 'text-brand-600' : 'text-slate-400'" class="flex items-center justify-center gap-2">
                    <span :class="step >= 3 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-500'" class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]">3</span>
                    <span>Activation</span>
                </div>
            </div>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
            @csrf
            <input type="hidden" name="plan_id" :value="selectedPlan">
            <input type="hidden" name="billing_cycle" :value="billingCycle">

            <!-- STEP 1: Dairy & Owner Info -->
            <div x-show="step === 1" class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3">1. Dairy & Owner Details</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Dairy Shop Name *</label>
                        <input type="text" name="dairy_name" x-model="dairyName" required placeholder="e.g. Maa Durga Dairy" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Owner Name *</label>
                        <input type="text" name="owner_name" x-model="ownerName" required placeholder="e.g. Mukesh Sharma" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Mobile (WhatsApp) *</label>
                        <input type="tel" name="mobile" x-model="mobile" required placeholder="+91 98260 11111" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Email Address *</label>
                        <input type="email" name="email" x-model="email" required placeholder="owner@dairy.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">City / Hub *</label>
                        <select name="city" x-model="city" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                            <option value="Indore">Indore</option>
                            <option value="Bhopal">Bhopal</option>
                            <option value="Ujjain">Ujjain</option>
                            <option value="Dewas">Dewas</option>
                            <option value="Rau">Rau</option>
                            <option value="Other">Other City</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Portal Password *</label>
                        <input type="password" name="password" x-model="password" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50">
                    </div>
                </div>

                <div class="text-xs">
                    <label class="block font-semibold text-slate-700 mb-1">Shop Address *</label>
                    <textarea name="address" x-model="address" rows="2" placeholder="e.g. Shop 4, Main Square, Near Bus Stand" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 bg-slate-50/50" required></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" @click="if(dairyName && ownerName && mobile && email && address) { step = 2; } else { alert('Please fill in all required fields.'); }" 
                            class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow transition flex items-center gap-2">
                        <span>Continue to Subscription Plan</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Choose Subscription Plan -->
            <div x-show="step === 2" x-cloak class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="text-lg font-bold text-slate-900">2. Select Your Subscription Plan</h3>
                    <!-- Billing cycle toggle -->
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-bold">
                        <button type="button" @click="billingCycle = 'monthly'" :class="billingCycle === 'monthly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'" class="px-3 py-1 rounded-lg">Monthly</button>
                        <button type="button" @click="billingCycle = 'yearly'" :class="billingCycle === 'yearly' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'" class="px-3 py-1 rounded-lg">Yearly (20% Off)</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($plans as $plan)
                    <div @click="selectedPlan = {{ $plan->id }}" 
                         :class="selectedPlan == {{ $plan->id }} ? 'border-2 border-brand-600 bg-brand-50/30 ring-2 ring-brand-500/20' : 'border border-slate-200 bg-white'"
                         class="p-5 rounded-2xl cursor-pointer hover:border-brand-400 transition relative flex flex-col justify-between">
                        @if($plan->is_popular)
                        <span class="absolute -top-2.5 right-4 px-2 py-0.5 rounded bg-brand-600 text-white text-[10px] font-bold uppercase">Popular</span>
                        @endif
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-bold text-slate-900 text-sm">{{ $plan->name }}</h4>
                                <span class="w-4 h-4 rounded-full border flex items-center justify-center" :class="selectedPlan == {{ $plan->id }} ? 'border-brand-600 bg-brand-600' : 'border-slate-300'">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white" x-show="selectedPlan == {{ $plan->id }}"></span>
                                </span>
                            </div>
                            <div class="text-xl font-extrabold text-slate-900 mb-1">
                                <span x-show="billingCycle === 'monthly'">₹{{ number_format($plan->price_monthly) }}<span class="text-xs font-normal text-slate-500">/mo</span></span>
                                <span x-show="billingCycle === 'yearly'">₹{{ number_format($plan->price_yearly) }}<span class="text-xs font-normal text-slate-500">/yr</span></span>
                            </div>
                            <p class="text-[11px] text-slate-500 mb-4">{{ $plan->tagline }}</p>
                            <ul class="text-[11px] text-slate-600 space-y-1.5 border-t pt-3">
                                <li>• {{ $plan->customer_limit }} Customers Limit</li>
                                <li>• {{ $plan->staff_limit }} Staff Logins</li>
                                <li>• Daily Milk & Shift Tracking</li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pt-4 flex items-center justify-between border-t">
                    <button type="button" @click="step = 1" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold">
                        &larr; Back
                    </button>
                    <button type="button" @click="step = 3" class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow transition flex items-center gap-2">
                        <span>Proceed to Simulated Payment</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 3: Payment & Instant Activation -->
            <div x-show="step === 3" x-cloak class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b pb-3">3. Subscription Payment & Verification</h3>

                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-xs text-slate-500">Selected Subscription:</span>
                        <div class="text-base font-bold text-slate-900">
                            <span x-text="selectedPlan == 1 ? 'Basic Plan' : (selectedPlan == 2 ? 'Standard Plan' : 'Premium Plan')"></span> 
                            (<span x-text="billingCycle"></span>)
                        </div>
                        <span class="text-xs text-brand-600 font-semibold">Includes 14-day money-back guarantee</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-500">Total Payable:</span>
                        <div class="text-2xl font-black text-brand-600">₹<span x-text="getPlanPrice()"></span></div>
                    </div>
                </div>

                <!-- Simulated UPI QR Box -->
                <div class="border border-slate-200 p-5 rounded-2xl space-y-4 text-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Instant Simulated Demo Payment
                    </div>
                    <p class="text-xs text-slate-600 max-w-md mx-auto">
                        For this client demonstration, clicking <strong>"Verify & Activate Subscription"</strong> will simulate an instant UPI transaction, register your tenant, and log you directly into your new Dairy Admin Dashboard!
                    </p>
                </div>

                <div class="pt-4 flex items-center justify-between border-t">
                    <button type="button" @click="step = 2" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold">
                        &larr; Back
                    </button>
                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-600/25 transition flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>Verify & Activate Subscription</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            Already have an active dairy account? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700">Sign in here</a>
        </div>
    </div>
</div>
@endsection
