<?php

namespace App\Http\Controllers;

use App\Models\Dairy;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$field => $login, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'login' => 'Invalid login credentials provided.',
        ])->withInput();
    }

    public function showRegister()
    {
        $plans = SubscriptionPlan::orderBy('price_monthly')->get();
        return view('auth.register', compact('plans'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'dairy_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'password' => 'required|string|min:6',
            'plan_id' => 'required|exists:subscription_plans,id',
            'billing_cycle' => 'required|in:monthly,half_yearly,yearly',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        $amount = match($request->billing_cycle) {
            'half_yearly' => $plan->price_half_yearly,
            'yearly' => $plan->price_yearly,
            default => $plan->price_monthly,
        };

        // Create Dairy
        $dairy = Dairy::create([
            'name' => $request->dairy_name,
            'slug' => Str::slug($request->dairy_name) . '-' . rand(100, 999),
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->mobile,
            'city' => $request->city,
            'address' => $request->address,
            'status' => 'active', // Active immediately for demo seamlessness
        ]);

        // Create Dairy Admin User
        $user = User::create([
            'dairy_id' => $dairy->id,
            'name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->mobile,
            'role' => 'dairy_admin',
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        // Create Subscription
        $months = match($request->billing_cycle) {
            'half_yearly' => 6,
            'yearly' => 12,
            default => 1,
        };

        $subscription = Subscription::create([
            'dairy_id' => $dairy->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $request->billing_cycle,
            'amount' => $amount,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonths($months),
            'status' => 'active',
            'auto_renew' => true,
        ]);

        // Create Payment Record
        Payment::create([
            'transaction_id' => 'SUB-' . strtoupper(Str::random(8)),
            'reference_no' => 'UPI/' . rand(1000000000, 9999999999),
            'dairy_id' => $dairy->id,
            'subscription_id' => $subscription->id,
            'type' => 'subscription',
            'amount' => $amount,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now(),
            'status' => 'approved',
            'notes' => 'Online registration subscription payment verified.',
        ]);

        Auth::login($user);

        return redirect()->route('dairy.dashboard')->with('success', 'Congratulations! Your dairy ' . $dairy->name . ' is registered and active on the ' . $plan->name . ' Plan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'You have been logged out.');
    }

    public function switchRole($role)
    {
        $user = match($role) {
            'super_admin' => User::where('role', 'super_admin')->first(),
            'dairy_admin' => User::where('role', 'dairy_admin')->first(),
            'customer' => User::where('role', 'customer')->first(),
            default => null,
        };

        if ($user) {
            Auth::login($user);
            return $this->redirectBasedOnRole($user)->with('success', 'Switched session to ' . ucwords(str_replace('_', ' ', $role)) . ' (' . $user->name . ')');
        }

        return redirect()->route('login')->with('error', 'Demo account not found.');
    }

    public function resetDemo()
    {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            if ($user) {
                Auth::login($user);
                return back()->with('success', 'Demo database restored to fresh showcase state!');
            }
        }

        return redirect()->route('home')->with('success', 'Demo database restored to fresh showcase state!');
    }

    private function redirectBasedOnRole(User $user)
    {
        return match($user->role) {
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'dairy_admin', 'staff' => redirect()->route('dairy.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
