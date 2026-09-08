@extends('layouts.admin')

@section('title', 'Reports & Intelligence - MilkFlow')
@section('page_title', 'Analytics & Export Desk')

@section('content')
<div class="space-y-6">
    <!-- Action Bar with Export Buttons -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Commercial Dairy Business Reports</h3>
            <p class="text-xs text-slate-500">Filter by dates, street routes, and export certified accounting ledgers.</p>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="alert('Exporting PDF Ledger Statement...')" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow transition flex items-center gap-1.5">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                <span>Export PDF Ledger</span>
            </button>
            <button onclick="alert('Exporting Excel Monthly Spreadsheet...')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow transition flex items-center gap-1.5">
                <i data-lucide="sheet" class="w-3.5 h-3.5"></i>
                <span>Export Excel</span>
            </button>
        </div>
    </div>

    <!-- 9 Pre-Configured Report Modules (As Required by Prompt) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- 1. Daily Milk Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="sun" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Daily Milk Report</h4>
            <p class="text-xs text-slate-500">Detailed shift tally for morning and evening distribution, skips, and extras.</p>
            <button onclick="alert('Generating Daily Milk Report for Today (486 L)...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Today's Report &rarr;
            </button>
        </div>

        <!-- 2. Monthly Milk Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Monthly Milk Report</h4>
            <p class="text-xs text-slate-500">Total litres distributed per customer across 30 days. Perfect for customer auditing.</p>
            <button onclick="alert('Generating September Month Report (14,580 L)...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Month Report &rarr;
            </button>
        </div>

        <!-- 3. Customer Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Customer Analysis Report</h4>
            <p class="text-xs text-slate-500">Customer growth, paused subscriptions, churn rate, and route density analytics.</p>
            <button onclick="alert('Generating Customer Insights Report...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                Analyze Customers &rarr;
            </button>
        </div>

        <!-- 4. Revenue Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="indian-rupee" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Revenue & Sales Report</h4>
            <p class="text-xs text-slate-500">Complete gross earnings breakdown across Cow Milk, Buffalo Milk, Curd, and Ghee.</p>
            <button onclick="alert('Generating Revenue Report (₹3.84 Lakhs)...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Earnings Breakdown &rarr;
            </button>
        </div>

        <!-- 5. Payment Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Payment Collection Report</h4>
            <p class="text-xs text-slate-500">Reconciliation report comparing digital UPI collections versus counter cash.</p>
            <button onclick="alert('Generating Collection Ledger...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                Reconcile Payments &rarr;
            </button>
        </div>

        <!-- 6. Pending Payment Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Pending Dues & Aging Report</h4>
            <p class="text-xs text-slate-500">List of customers with overdue balances exceeding 7, 15, or 30 days.</p>
            <button onclick="alert('Generating Overdue List (₹12,680 total across 14 customers)...')" class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1">
                View Dues List &rarr;
            </button>
        </div>

        <!-- 7. Delivery Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="truck" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Delivery Boy Route Report</h4>
            <p class="text-xs text-slate-500">Delivery speed, drop accuracy, and cash collections per delivery boy.</p>
            <button onclick="alert('Generating Delivery Performance Report...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Delivery Boy Performance &rarr;
            </button>
        </div>

        <!-- 8. Product Sales Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Product Sales (Ghee / Paneer)</h4>
            <p class="text-xs text-slate-500">Volume sold, unit margins, and inventory turnover of value-add dairy items.</p>
            <button onclick="alert('Generating Inventory Report...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Product Sales &rarr;
            </button>
        </div>

        <!-- 9. Expense Report -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                <i data-lucide="pie-chart" class="w-5 h-5"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900">Shop Expense & Margins</h4>
            <p class="text-xs text-slate-500">Procurement costs, delivery fuel, staff salaries, and net operating profit.</p>
            <button onclick="alert('Generating Profit & Loss Summary (Net Margin: 24%)...')" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                View Profit & Loss &rarr;
            </button>
        </div>
    </div>
</div>
@endsection
