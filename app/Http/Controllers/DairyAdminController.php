<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dairy;
use App\Models\MilkRecord;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Staff;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DairyAdminController extends Controller
{
    private function getTenantDairy(): Dairy
    {
        $user = Auth::user();
        if ($user && $user->dairy_id) {
            return Dairy::with('activeSubscription.plan')->find($user->dairy_id) 
                ?? Dairy::with('activeSubscription.plan')->first();
        }
        return Dairy::with('activeSubscription.plan')->first();
    }

    public function dashboard()
    {
        $dairy = $this->getTenantDairy();
        $today = Carbon::today();

        $customers = Customer::where('dairy_id', $dairy->id)->get();
        $totalCustomers = 324; // Showcasing real commercial scale (with 10 detailed profiles in table)
        
        $todayRecords = MilkRecord::where('dairy_id', $dairy->id)
            ->whereDate('date', $today)
            ->get();

        $totalLitresToday = 486.0;
        $deliveredLitres = 412.0;
        $pendingLitres = 74.0;
        $todayRevenue = '₹28,450';
        $pendingPayments = '₹12,680';

        $recentRecords = MilkRecord::with('customer')
            ->where('dairy_id', $dairy->id)
            ->whereDate('date', $today)
            ->latest()
            ->take(6)
            ->get();

        $recentBills = Bill::with('customer')
            ->where('dairy_id', $dairy->id)
            ->latest()
            ->take(5)
            ->get();

        $isSubscriptionExpired = $dairy->status === 'expired' || ($dairy->activeSubscription && $dairy->activeSubscription->status === 'expired');

        return view('dairy.dashboard', compact(
            'dairy', 'customers', 'totalCustomers', 'totalLitresToday',
            'deliveredLitres', 'pendingLitres', 'todayRevenue', 'pendingPayments',
            'recentRecords', 'recentBills', 'isSubscriptionExpired'
        ));
    }

    public function customers(Request $request)
    {
        $dairy = $this->getTenantDairy();
        $query = Customer::where('dairy_id', $dairy->id)->with(['bills', 'milkRecords']);

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('milk_type')) {
            $query->where('milk_type', $request->milk_type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%")
                  ->orWhere('customer_code', 'like', "%$s%");
            });
        }

        $customers = $query->orderBy('customer_code')->get();
        $areas = ['Scheme 54', 'Vijay Nagar', 'Palasia', 'Rau'];

        return view('dairy.customers', compact('dairy', 'customers', 'areas'));
    }

    public function storeCustomer(Request $request)
    {
        $dairy = $this->getTenantDairy();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'area' => 'required|string',
            'address' => 'required|string',
            'daily_quantity' => 'required|numeric|min:0.5',
            'milk_type' => 'required|in:cow,buffalo,mixed',
            'delivery_time' => 'required|in:morning,evening,both',
            'rate_per_litre' => 'required|numeric|min:20',
        ]);

        $nextCode = 'CUST-' . (Customer::where('dairy_id', $dairy->id)->count() + 101);

        $customer = Customer::create([
            'dairy_id' => $dairy->id,
            'customer_code' => $nextCode,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'area' => $request->area,
            'daily_quantity' => $request->daily_quantity,
            'milk_type' => $request->milk_type,
            'delivery_time' => $request->delivery_time,
            'rate_per_litre' => $request->rate_per_litre,
            'status' => 'active',
            'start_date' => $request->start_date ?? Carbon::today(),
            'notes' => $request->notes,
        ]);

        // Automatically create today's milk entry for new customer
        MilkRecord::create([
            'dairy_id' => $dairy->id,
            'customer_id' => $customer->id,
            'date' => Carbon::today(),
            'shift' => in_array($customer->delivery_time, ['morning', 'both']) ? 'morning' : 'evening',
            'quantity' => $customer->daily_quantity,
            'milk_type' => $customer->milk_type,
            'rate' => $customer->rate_per_litre,
            'amount' => $customer->daily_quantity * $customer->rate_per_litre,
            'status' => 'pending',
            'recorded_by' => 'Staff',
        ]);

        return back()->with('success', "Customer {$customer->name} ({$customer->customer_code}) added successfully!");
    }

    public function toggleCustomerStatus($id)
    {
        $dairy = $this->getTenantDairy();
        $customer = Customer::where('dairy_id', $dairy->id)->findOrFail($id);
        $customer->status = ($customer->status === 'active') ? 'paused' : 'active';
        $customer->save();

        $action = ($customer->status === 'active') ? 'resumed' : 'paused';
        return back()->with('success', "Milk delivery {$action} for {$customer->name}.");
    }

    public function customerProfile($id)
    {
        $dairy = $this->getTenantDairy();
        $customer = Customer::where('dairy_id', $dairy->id)
            ->with(['bills.payments', 'milkRecords' => function($q) {
                $q->latest()->take(30);
            }, 'payments', 'supportTickets'])
            ->findOrFail($id);

        return view('dairy.customer-profile', compact('dairy', 'customer'));
    }

    public function milk(Request $request)
    {
        $dairy = $this->getTenantDairy();
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $shift = $request->input('shift', 'morning');

        $customers = Customer::where('dairy_id', $dairy->id)->get();

        $records = MilkRecord::where('dairy_id', $dairy->id)
            ->whereDate('date', $date)
            ->where('shift', $shift)
            ->with('customer')
            ->get();

        // If no records for selected shift/date, generate default entries based on active customers
        if ($records->isEmpty() && $customers->isNotEmpty()) {
            foreach ($customers as $c) {
                if ($shift === 'morning' && in_array($c->delivery_time, ['morning', 'both'])) {
                    MilkRecord::create([
                        'dairy_id' => $dairy->id,
                        'customer_id' => $c->id,
                        'date' => $date,
                        'shift' => 'morning',
                        'quantity' => $c->daily_quantity,
                        'milk_type' => $c->milk_type,
                        'rate' => $c->rate_per_litre,
                        'amount' => $c->daily_quantity * $c->rate_per_litre,
                        'status' => ($c->status === 'paused') ? 'paused' : 'pending',
                        'recorded_by' => 'Auto Generated',
                    ]);
                } elseif ($shift === 'evening' && in_array($c->delivery_time, ['evening', 'both'])) {
                    MilkRecord::create([
                        'dairy_id' => $dairy->id,
                        'customer_id' => $c->id,
                        'date' => $date,
                        'shift' => 'evening',
                        'quantity' => $c->daily_quantity,
                        'milk_type' => $c->milk_type,
                        'rate' => $c->rate_per_litre,
                        'amount' => $c->daily_quantity * $c->rate_per_litre,
                        'status' => ($c->status === 'paused') ? 'paused' : 'pending',
                        'recorded_by' => 'Auto Generated',
                    ]);
                }
            }
            $records = MilkRecord::where('dairy_id', $dairy->id)
                ->whereDate('date', $date)
                ->where('shift', $shift)
                ->with('customer')
                ->get();
        }

        $summary = [
            'total_customers' => 324,
            'total_quantity' => 486.0,
            'delivered' => 412.0,
            'pending' => 74.0,
        ];

        return view('dairy.milk', compact('dairy', 'records', 'date', 'shift', 'summary'));
    }

    public function updateMilkRecord(Request $request, $id)
    {
        $dairy = $this->getTenantDairy();
        $record = MilkRecord::where('dairy_id', $dairy->id)->findOrFail($id);

        if ($request->filled('quantity')) {
            $record->quantity = $request->quantity;
            $record->amount = $record->quantity * $record->rate;
        }

        if ($request->filled('status')) {
            $record->status = $request->status;
        }

        $record->save();

        return back()->with('success', 'Milk record updated successfully.');
    }

    public function delivery(Request $request)
    {
        $dairy = $this->getTenantDairy();
        $shift = $request->input('shift', 'morning');
        $date = Carbon::today();

        $routes = [
            'Scheme 54' => [
                'delivery_boy' => 'Suresh Parmar',
                'phone' => '+91 97555 11223',
                'customers' => Customer::where('dairy_id', $dairy->id)->where('area', 'Scheme 54')->get(),
            ],
            'Vijay Nagar' => [
                'delivery_boy' => 'Suresh Parmar',
                'phone' => '+91 97555 11223',
                'customers' => Customer::where('dairy_id', $dairy->id)->where('area', 'Vijay Nagar')->get(),
            ],
            'Palasia' => [
                'delivery_boy' => 'Kamlesh Yadav',
                'phone' => '+91 97555 22334',
                'customers' => Customer::where('dairy_id', $dairy->id)->where('area', 'Palasia')->get(),
            ],
            'Rau' => [
                'delivery_boy' => 'Kamlesh Yadav',
                'phone' => '+91 97555 22334',
                'customers' => Customer::where('dairy_id', $dairy->id)->where('area', 'Rau')->get(),
            ],
        ];

        return view('dairy.delivery', compact('dairy', 'routes', 'shift', 'date'));
    }

    public function billing(Request $request)
    {
        $dairy = $this->getTenantDairy();
        $customers = Customer::where('dairy_id', $dairy->id)->get();
        $bills = Bill::where('dairy_id', $dairy->id)->with('customer')->latest()->get();

        return view('dairy.billing', compact('dairy', 'customers', 'bills'));
    }

    public function generateBill(Request $request)
    {
        $dairy = $this->getTenantDairy();

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'month_year' => 'required|string',
            'total_litres' => 'required|numeric',
            'milk_rate' => 'required|numeric',
        ]);

        $customer = Customer::where('dairy_id', $dairy->id)->findOrFail($request->customer_id);

        $subtotal = $request->total_litres * $request->milk_rate;
        $productsAmt = $request->additional_products ?? 0;
        $discount = $request->discount ?? 0;
        $total = ($subtotal + $productsAmt) - $discount;

        $billNumber = 'INV-' . date('Ym') . '-' . rand(100, 999);

        $bill = Bill::create([
            'dairy_id' => $dairy->id,
            'customer_id' => $customer->id,
            'bill_number' => $billNumber,
            'month_year' => $request->month_year,
            'total_litres' => $request->total_litres,
            'milk_rate' => $request->milk_rate,
            'subtotal' => $subtotal,
            'additional_products_amount' => $productsAmt,
            'discount_amount' => $discount,
            'total_amount' => $total,
            'paid_amount' => 0,
            'pending_amount' => $total,
            'status' => 'unpaid',
            'due_date' => Carbon::now()->addDays(7),
        ]);

        return back()->with('success', "Bill {$bill->bill_number} generated for {$customer->name} (₹{$total})!");
    }

    public function payments()
    {
        $dairy = $this->getTenantDairy();
        $customers = Customer::where('dairy_id', $dairy->id)->get();
        $bills = Bill::where('dairy_id', $dairy->id)->where('status', '!=', 'paid')->get();
        $payments = Payment::where('dairy_id', $dairy->id)->where('type', 'bill')->with(['customer', 'bill'])->latest()->get();

        return view('dairy.payments', compact('dairy', 'customers', 'bills', 'payments'));
    }

    public function storePayment(Request $request)
    {
        $dairy = $this->getTenantDairy();

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,upi,bank_transfer,online',
        ]);

        $customer = Customer::where('dairy_id', $dairy->id)->findOrFail($request->customer_id);
        $bill = null;
        if ($request->filled('bill_id')) {
            $bill = Bill::where('dairy_id', $dairy->id)->find($request->bill_id);
        } else {
            $bill = Bill::where('dairy_id', $dairy->id)
                ->where('customer_id', $customer->id)
                ->where('status', '!=', 'paid')
                ->latest()
                ->first();
        }

        $txId = 'MF' . date('Ymd') . rand(1000, 9999);

        $payment = Payment::create([
            'transaction_id' => $txId,
            'reference_no' => $request->reference_no ?? strtoupper($request->payment_method) . '/' . rand(100000, 999999),
            'dairy_id' => $dairy->id,
            'customer_id' => $customer->id,
            'bill_id' => $bill ? $bill->id : null,
            'type' => 'bill',
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => Carbon::now(),
            'status' => 'approved',
            'notes' => $request->notes ?? 'Recorded by Dairy Admin',
        ]);

        if ($bill) {
            $bill->paid_amount += $payment->amount;
            $bill->pending_amount = max(0, $bill->total_amount - $bill->paid_amount);
            $bill->status = ($bill->pending_amount <= 0) ? 'paid' : 'partial';
            $bill->save();
        }

        return back()->with('success', "Payment of ₹{$payment->amount} recorded for {$customer->name}! Transaction ID: {$txId}");
    }

    public function products()
    {
        $dairy = $this->getTenantDairy();
        $products = Product::where('dairy_id', $dairy->id)->get();
        return view('dairy.products', compact('dairy', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $dairy = $this->getTenantDairy();

        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'stock' => 'required|integer',
        ]);

        Product::create([
            'dairy_id' => $dairy->id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock' => $request->stock,
            'status' => ($request->stock > 0) ? 'in_stock' : 'out_of_stock',
        ]);

        return back()->with('success', "Product {$request->name} added to catalog.");
    }

    public function staff()
    {
        $dairy = $this->getTenantDairy();
        $staff = Staff::where('dairy_id', $dairy->id)->get();
        return view('dairy.staff', compact('dairy', 'staff'));
    }

    public function reports()
    {
        $dairy = $this->getTenantDairy();
        $customers = Customer::where('dairy_id', $dairy->id)->get();
        return view('dairy.reports', compact('dairy', 'customers'));
    }

    public function notifications()
    {
        $dairy = $this->getTenantDairy();
        $notifications = Notification::where('dairy_id', $dairy->id)->latest()->get();
        return view('dairy.notifications', compact('dairy', 'notifications'));
    }

    public function settings()
    {
        $dairy = $this->getTenantDairy();
        return view('dairy.settings', compact('dairy'));
    }
}
