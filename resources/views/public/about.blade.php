@extends('layouts.public')

@section('title', 'About MilkFlow - Smart Dairy Management')

@section('content')
<div class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Our Mission</span>
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mt-2">Empowering India's Dairy Entrepreneurs</h1>
        <p class="text-base text-slate-600 mt-4">Bridging traditional local dairy craftsmanship with cutting-edge SaaS technology.</p>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="space-y-6 text-slate-700 leading-relaxed text-sm">
            <h2 class="text-2xl font-bold text-slate-900">Why MilkFlow Was Created</h2>
            <p>
                Across towns and villages in Madhya Pradesh and beyond, the neighborhood dairy shop (दुग्धालय) is the heartbeat of local nutrition. Every morning before 5:00 AM, thousands of liters of fresh cow and buffalo milk are packaged and delivered to families.
            </p>
            <p>
                Yet, most dairy owners were managing millions of rupees worth of daily milk deliveries on battered physical notebooks (खाता बही), paper coupons, and chalkboards. Every month-end resulted in bitter disputes: "Did we take 2 liters or 1.5 liters on Friday?", "Did we pay for that 1 kg of paneer last week?", or lost slips when customers traveled out of town.
            </p>
            <p>
                <strong>MilkFlow was engineered from the ground up to solve this exact problem.</strong> We built a multi-tenant cloud software platform that is clean enough for an executive and intuitive enough for a local delivery boy riding a bicycle through morning streets.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
            <div class="p-5 rounded-2xl bg-brand-50/50 border border-brand-100 text-center">
                <div class="text-3xl font-extrabold text-brand-700 mb-1">Zero Tech Hassle</div>
                <p class="text-xs text-slate-600">Works directly on standard Android smartphones and web browsers.</p>
            </div>
            <div class="p-5 rounded-2xl bg-brand-50/50 border border-brand-100 text-center">
                <div class="text-3xl font-extrabold text-brand-700 mb-1">100% Data Privacy</div>
                <p class="text-xs text-slate-600">Every dairy's customer lists, rates, and cash collections are strictly isolated.</p>
            </div>
            <div class="p-5 rounded-2xl bg-brand-50/50 border border-brand-100 text-center">
                <div class="text-3xl font-extrabold text-brand-700 mb-1">Instant ROI</div>
                <p class="text-xs text-slate-600">Reduces billing disputes to zero and speeds up monthly cash collections by 70%.</p>
            </div>
        </div>
    </div>
</div>
@endsection
