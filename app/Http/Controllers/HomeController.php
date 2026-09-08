<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price_monthly')->get();
        return view('public.index', compact('plans'));
    }

    public function features()
    {
        return view('public.features');
    }

    public function howItWorks()
    {
        return view('public.how-it-works');
    }

    public function pricing()
    {
        $plans = SubscriptionPlan::orderBy('price_monthly')->get();
        return view('public.pricing', compact('plans'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
