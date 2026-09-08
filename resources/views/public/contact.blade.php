@extends('layouts.public')

@section('title', 'Contact & Demo Request - MilkFlow Dairy SaaS')

@section('content')
<div class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Get in Touch</span>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Let's Modernize Your Dairy</h1>
        <p class="text-base text-slate-600 mt-4">Have questions or want an in-person demonstration in Indore, Bhopal, or Ujjain? Our dairy technology specialists are here to help.</p>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-slate-900">Headquarters & Support</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Reach out to our customer success team for onboarding help, route setting, or custom multi-branch setup.
            </p>

            <div class="space-y-4 text-xs text-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <strong class="text-slate-900 block font-semibold">Central MP Hub</strong>
                        <span>Plot 42, Annapurna Road, Near Mandir, Indore, MP 452009</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <strong class="text-slate-900 block font-semibold">Direct Helpline</strong>
                        <span>+91 98260 12345 / +91 98260 00001 (WhatsApp & Calls)</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <strong class="text-slate-900 block font-semibold">Email Assistance</strong>
                        <span>support@milkflow.demo / partnerships@milkflow.demo</span>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-xs font-bold text-slate-900 block mb-1">Instant Demo Available</span>
                <p class="text-[11px] text-slate-500 mb-3">No need to wait for a salesperson. Explore the active platform right now with realistic demo data.</p>
                <a href="{{ route('demo.switch', 'dairy_admin') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700">
                    Open Shree Krishna Dairy Demo <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Request a Callback / On-Site Demo</h3>
            <form action="{{ route('contact') }}" method="GET" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Your Name</label>
                    <input type="text" placeholder="e.g. Rajesh Patel" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" required>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Dairy Shop Name</label>
                    <input type="text" placeholder="e.g. Shree Krishna Dairy" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Mobile (WhatsApp)</label>
                        <input type="tel" placeholder="+91 98260..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" required>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">City / Town</label>
                        <input type="text" placeholder="e.g. Indore" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" required>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Approximate Daily Litres</label>
                    <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                        <option>100 - 300 Litres / day</option>
                        <option>300 - 800 Litres / day</option>
                        <option>800 - 2,000+ Litres / day</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Message (Optional)</label>
                    <textarea rows="3" placeholder="Tell us about your current delivery challenges..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white"></textarea>
                </div>

                <button type="button" onclick="alert('Thank you! Your request has been received. A MilkFlow specialist will contact you on WhatsApp within 1 hour.')" class="w-full py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition">
                    Submit Demo Request
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
