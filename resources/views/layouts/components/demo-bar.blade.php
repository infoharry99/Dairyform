<div class="bg-slate-900 text-slate-200 text-xs py-2 px-4 border-b border-slate-800 shadow-sm sticky top-0 z-40 backdrop-blur-md bg-opacity-95">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
        <!-- Brand & Current Mode Indicator -->
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase bg-brand-500/20 text-brand-400 border border-brand-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse"></span>
                Showcase Mode
            </span>
            <span class="hidden sm:inline text-slate-400">|</span>
            <span class="text-slate-300 font-medium">
                Active: 
                @if(Auth::check())
                    @if(Auth::user()->isSuperAdmin())
                        <strong class="text-indigo-400">Super Admin (Platform Owner)</strong>
                    @elseif(Auth::user()->isDairyAdmin())
                        <strong class="text-brand-400">Dairy Admin ({{ Auth::user()->dairy->name ?? 'Shree Krishna Dairy' }})</strong>
                    @elseif(Auth::user()->isCustomer())
                        <strong class="text-amber-400">Customer ({{ Auth::user()->name }} - Scheme 54)</strong>
                    @else
                        <strong class="text-slate-300">{{ Auth::user()->name }}</strong>
                    @endif
                @else
                    <strong class="text-slate-400">Guest Visitor</strong>
                @endif
            </span>
        </div>

        <!-- Role Quick Switcher & Guide Buttons -->
        <div class="flex items-center flex-wrap gap-1.5 sm:gap-2">
            <span class="hidden md:inline text-slate-400 text-[11px]">Switch Role:</span>
            
            <a href="{{ route('demo.switch', 'super_admin') }}" 
               class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition flex items-center gap-1.5 {{ Auth::check() && Auth::user()->isSuperAdmin() ? 'bg-indigo-600 text-white shadow' : 'bg-slate-800 hover:bg-slate-700 text-slate-300' }}">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                Super Admin
            </a>

            <a href="{{ route('demo.switch', 'dairy_admin') }}" 
               class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition flex items-center gap-1.5 {{ Auth::check() && Auth::user()->isDairyAdmin() ? 'bg-brand-600 text-white shadow' : 'bg-slate-800 hover:bg-slate-700 text-slate-300' }}">
                <i data-lucide="store" class="w-3.5 h-3.5"></i>
                Dairy Admin
            </a>

            <a href="{{ route('demo.switch', 'customer') }}" 
               class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition flex items-center gap-1.5 {{ Auth::check() && Auth::user()->isCustomer() ? 'bg-amber-600 text-white shadow' : 'bg-slate-800 hover:bg-slate-700 text-slate-300' }}">
                <i data-lucide="smartphone" class="w-3.5 h-3.5"></i>
                Customer App
            </a>

            <div class="h-4 w-px bg-slate-700 mx-1 hidden sm:block"></div>

            <!-- 5-Minute Tour Guide Modal Trigger -->
            <button @click="demoTourOpen = true" 
                    class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 border border-emerald-500/40 transition flex items-center gap-1.5">
                <i data-lucide="compass" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>5-Min SaaS Tour</span>
            </button>

            <!-- Reset Demo Database -->
            <a href="{{ route('demo.reset') }}" onclick="return confirm('Restore demo data to default showcase state?')" 
               class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-slate-800 hover:bg-rose-900/40 text-slate-400 hover:text-rose-300 transition flex items-center gap-1" title="Reset Demo Data">
                <i data-lucide="rotate-ccw" class="w-3 h-3"></i>
                <span class="hidden lg:inline">Reset</span>
            </a>
        </div>
    </div>
</div>

<!-- 5-Minute Guided Demo Tour Modal -->
<div x-cloak x-show="demoTourOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="demoTourOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="demoTourOpen = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="demoTourOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
            <div class="bg-gradient-to-r from-slate-900 to-brand-950 p-6 text-white flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-400"></span>
                        <span class="text-xs uppercase tracking-widest text-brand-300 font-bold">Client Showcase Guide</span>
                    </div>
                    <h3 class="text-xl font-bold">MilkFlow 5-Minute Product Journey</h3>
                    <p class="text-xs text-slate-300 mt-1">Follow this recommended flow to demonstrate the full commercial value to prospective clients and dairy owners.</p>
                </div>
                <button @click="demoTourOpen = false" class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">1</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Public SaaS Landing Page & Pricing</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Explore the consumer-facing marketing site, real-time statistics (500+ Dairies, 1M+ L managed), and monthly/yearly pricing tiers.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 mt-2">
                            Go to Public Landing Page <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">2</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Dairy Self-Registration & Plan Selection</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Test how a new dairy owner in Indore or Bhopal registers their shop, picks the Standard Plan, and completes simulated UPI verification.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 mt-2">
                            View Dairy Registration Wizard <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs shrink-0">3</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Super Admin Multi-Tenant Oversight</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Review 1,248 registered dairies, approve pending subscription payments (e.g. Annapurna Dairy), manage plan limits, and inspect revenue.</p>
                        <a href="{{ route('demo.switch', 'super_admin') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 mt-2">
                            Open Super Admin Portal <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">4</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Dairy Admin Daily Milk & Route Delivery</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Switch to <em>Shree Krishna Dairy</em>. Record Morning shift milk, review area routes (Vijay Nagar, Scheme 54, Palasia), and view live summary counters.</p>
                        <a href="{{ route('demo.switch', 'dairy_admin') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 mt-2">
                            Open Dairy Admin Dashboard <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">5</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Automated Billing & WhatsApp Invoice</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Generate monthly bill (Total Milk + Extra Products - Discount), view printable invoice, and trigger automated WhatsApp reminder preview.</p>
                        <a href="{{ route('dairy.billing') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 mt-2">
                            Open Dairy Billing Module <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-brand-500/50 transition">
                    <div class="w-7 h-7 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs shrink-0">6</div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-900">Customer Mobile App & Instant UPI Payment</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Switch to customer <em>Rajesh Sharma</em>. View today's delivered milk, inspect September bill, and click <strong>Pay Now</strong> to experience instant simulated UPI payment with confetti!</p>
                        <a href="{{ route('demo.switch', 'customer') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700 mt-2">
                            Open Customer Mobile App <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                <span class="text-xs text-slate-500">Need to start fresh?</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('demo.reset') }}" onclick="return confirm('Restore demo data?')" class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 transition">
                        Reset All Demo Data
                    </a>
                    <button @click="demoTourOpen = false" class="px-4 py-1.5 rounded-lg text-xs font-semibold bg-brand-600 hover:bg-brand-700 text-white shadow-sm transition">
                        Got it, Let's Explore
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
