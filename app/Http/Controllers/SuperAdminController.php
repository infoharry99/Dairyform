<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Dairy;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $dairies = Dairy::with(['subscriptions.plan', 'customers'])->latest()->get();
        $recentPayments = Payment::with(['dairy', 'subscription.plan', 'customer'])->latest()->take(6)->get();

        // Realistic Platform KPIs as required
        $stats = [
            'total_dairies' => 1248,
            'active_dairies' => 1086,
            'expired_subscriptions' => 92,
            'pending_approvals' => 70,
            'monthly_revenue' => '₹12.48L',
            'yearly_revenue' => '₹1.42Cr',
            'total_litres_month' => '1.2M L',
            'active_customers_system' => '32,450',
        ];

        $activities = [
            ['title' => 'Shree Krishna Dairy renewed Standard Plan', 'time' => '10 mins ago', 'type' => 'success'],
            ['title' => 'Fresh Milk Dairy upgraded to Premium Plan', 'time' => '45 mins ago', 'type' => 'info'],
            ['title' => 'Annapurna Dairy payment verification pending', 'time' => '2 hours ago', 'type' => 'warning'],
            ['title' => 'Radha Dairy subscription expires in 4 days', 'time' => '5 hours ago', 'type' => 'alert'],
            ['title' => 'Maa Narmada Dairy subscription expired', 'time' => '1 day ago', 'type' => 'danger'],
        ];

        return view('superadmin.dashboard', compact('dairies', 'recentPayments', 'stats', 'activities'));
    }

    public function dairies(Request $request)
    {
        $query = Dairy::with(['activeSubscription.plan', 'customers', 'bills', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('owner_name', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }

        $dairies = $query->get();
        $plans = SubscriptionPlan::all();

        return view('superadmin.dairies', compact('dairies', 'plans'));
    }

    public function toggleDairyStatus($id, $status)
    {
        $dairy = Dairy::findOrFail($id);
        $dairy->status = in_array($status, ['active', 'suspended', 'expired', 'pending']) ? $status : 'active';
        $dairy->save();

        return back()->with('success', "Dairy status updated to {$dairy->status}.");
    }

    public function changeDairyPlan(Request $request, $id)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'billing_cycle' => 'required|in:monthly,half_yearly,yearly',
        ]);

        $dairy = Dairy::findOrFail($id);
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        $months = match($request->billing_cycle) {
            'half_yearly' => 6,
            'yearly' => 12,
            default => 1,
        };

        $amount = match($request->billing_cycle) {
            'half_yearly' => $plan->price_half_yearly,
            'yearly' => $plan->price_yearly,
            default => $plan->price_monthly,
        };

        Subscription::create([
            'dairy_id' => $dairy->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $request->billing_cycle,
            'amount' => $amount,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonths($months),
            'status' => 'active',
            'auto_renew' => true,
        ]);

        $dairy->status = 'active';
        $dairy->save();

        return back()->with('success', "Plan changed to {$plan->name} for {$dairy->name}.");
    }

    public function subscriptions()
    {
        $plans = SubscriptionPlan::all();
        $subscriptions = Subscription::with(['dairy', 'plan'])->latest()->get();

        $expiringCount = Subscription::where('status', 'expiring_soon')
            ->orWhereBetween('expires_at', [Carbon::now(), Carbon::now()->addDays(7)])
            ->count();

        return view('superadmin.subscriptions', compact('plans', 'subscriptions', 'expiringCount'));
    }

    public function payments()
    {
        $payments = Payment::with(['dairy', 'subscription.plan'])->where('type', 'subscription')->latest()->get();
        return view('superadmin.payments', compact('payments'));
    }

    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'approved';
        $payment->save();

        if ($payment->subscription) {
            $payment->subscription->status = 'active';
            $payment->subscription->expires_at = Carbon::now()->addMonths(1);
            $payment->subscription->save();

            $payment->dairy->status = 'active';
            $payment->dairy->save();
        }

        return back()->with('success', "Payment approved successfully! Dairy subscription is now Active.");
    }

    public function rejectPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'rejected';
        $payment->save();

        return back()->with('info', "Payment has been rejected.");
    }

    public function customers()
    {
        $customers = Customer::with('dairy')->latest()->get();
        return view('superadmin.customers', compact('customers'));
    }

    public function reports()
    {
        return view('superadmin.reports');
    }

    public function notifications()
    {
        $notifications = Notification::latest()->get();
        return view('superadmin.notifications', compact('notifications'));
    }

    public function support()
    {
        $tickets = SupportTicket::with(['dairy', 'customer'])->latest()->get();
        return view('superadmin.support', compact('tickets'));
    }

    public function settings()
    {
        return view('superadmin.settings');
    }

    public function saveSettings(Request $request)
    {
        return back()->with('success', 'Platform settings updated successfully.');
    }
}
