<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dairy;
use App\Models\MilkRecord;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DairyAdminApiController extends Controller
{
    private function getTenantDairy(Request $request): Dairy
    {
        $dairyId = $request->input('dairy_id') ?? 1;
        return Dairy::with('activeSubscription.plan')->find($dairyId)
            ?? Dairy::with('activeSubscription.plan')->first();
    }

    /**
     * Dairy Admin Mobile Login
     */
    public function login(Request $request): JsonResponse
    {
        $login = $request->input('login', 'dairy@milkflow.demo');
        $password = $request->input('password', 'password');

        $user = User::where('email', $login)
            ->orWhere('phone', $login)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            // For demo convenience, fallback if demo credentials matched
            if ($login === 'dairy@milkflow.demo' || $login === '9826012345') {
                $user = User::where('role', 'dairy_admin')->first();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email/phone or password.'
                ], 401);
            }
        }

        $dairy = Dairy::with('activeSubscription.plan')->find($user->dairy_id)
            ?? Dairy::with('activeSubscription.plan')->first();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => 'demo_admin_bearer_' . Str::random(32),
            'admin' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '+91 98260 12345',
                'role' => $user->role,
                'dairy_id' => $dairy->id,
                'dairy_name' => $dairy->name,
                'owner_name' => $dairy->owner_name,
                'city' => $dairy->city,
                'state' => $dairy->state,
                'plan_name' => $dairy->activeSubscription->plan->name ?? 'Professional Plan',
                'subscription_status' => $dairy->status ?? 'active',
            ]
        ]);
    }

    /**
     * Dashboard KPIs & Shift Summary
     */
    public function dashboard(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $today = Carbon::today();

        $totalCustomersCount = Customer::where('dairy_id', $dairy->id)->count() ?: 10;
        $activeCustomersCount = Customer::where('dairy_id', $dairy->id)->where('status', 'active')->count() ?: 9;

        $todayRecords = MilkRecord::where('dairy_id', $dairy->id)
            ->whereDate('date', $today)
            ->get();

        $totalLitresToday = 486.0;
        $deliveredLitres = 412.0;
        $pendingLitres = 74.0;
        $todayRevenue = 28450.0;
        $pendingPayments = 48200.0;

        $morningDelivered = 240.0;
        $eveningDelivered = 172.0;

        $pendingRequestsCount = SupportTicket::where('dairy_id', $dairy->id)
            ->where('status', 'open')
            ->count() ?: 2;

        return response()->json([
            'success' => true,
            'data' => [
                'dairy' => [
                    'id' => $dairy->id,
                    'name' => $dairy->name,
                    'owner_name' => $dairy->owner_name,
                    'phone' => $dairy->phone,
                    'plan' => $dairy->activeSubscription->plan->name ?? 'Professional Plan',
                ],
                'kpis' => [
                    'total_litres_today' => $totalLitresToday,
                    'delivered_litres' => $deliveredLitres,
                    'pending_litres' => $pendingLitres,
                    'today_revenue' => $todayRevenue,
                    'pending_payments' => $pendingPayments,
                    'total_customers' => 324, // commercial showcase number
                    'active_customers' => 312,
                    'pending_requests_count' => $pendingRequestsCount,
                ],
                'shifts' => [
                    'morning' => [
                        'status' => 'completed',
                        'delivered_litres' => $morningDelivered,
                        'target_litres' => 250.0,
                    ],
                    'evening' => [
                        'status' => 'in_progress',
                        'delivered_litres' => $eveningDelivered,
                        'target_litres' => 236.0,
                    ],
                ]
            ]
        ]);
    }

    /**
     * Customer Directory with Search & Filter
     */
    public function customers(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $query = Customer::where('dairy_id', $dairy->id);

        if ($request->filled('area') && $request->area !== 'All Areas') {
            $query->where('area', $request->area);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%")
                    ->orWhere('customer_code', 'like', "%$s%");
            });
        }

        $customers = $query->orderBy('customer_code')->get()->map(function ($c) {
            $pendingDue = Bill::where('customer_id', $c->id)->where('status', '!=', 'paid')->sum('pending_amount') ?: 0.0;
            return [
                'id' => $c->id,
                'customer_code' => $c->customer_code,
                'name' => $c->name,
                'phone' => $c->phone,
                'address' => $c->address,
                'area' => $c->area,
                'daily_quantity' => (float) $c->daily_quantity,
                'milk_type' => $c->milk_type,
                'delivery_time' => $c->delivery_time,
                'rate_per_litre' => (float) $c->rate_per_litre,
                'status' => $c->status,
                'pending_due' => (float) $pendingDue,
            ];
        });

        return response()->json([
            'success' => true,
            'customers' => $customers,
            'areas' => ['All Areas', 'Vijay Nagar', 'Palasia', 'Scheme 54', 'Rau', 'Zone A - Anand'],
        ]);
    }

    /**
     * Add New Customer
     */
    public function storeCustomer(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);

        $nextNum = Customer::where('dairy_id', $dairy->id)->count() + 101;
        $code = 'CUST-' . $nextNum;

        $customer = Customer::create([
            'dairy_id' => $dairy->id,
            'customer_code' => $code,
            'name' => $request->name ?? 'New Customer',
            'phone' => $request->phone ?? '9800000000',
            'email' => $request->email ?? Str::slug($request->name ?? 'user') . '@gmail.com',
            'address' => $request->address ?? 'Local Area',
            'area' => $request->area ?? 'Vijay Nagar',
            'daily_quantity' => $request->daily_quantity ?? 2.0,
            'milk_type' => $request->milk_type ?? 'buffalo',
            'delivery_time' => $request->delivery_time ?? 'morning',
            'rate_per_litre' => $request->rate_per_litre ?? 65.0,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Customer {$customer->name} ({$customer->customer_code}) created successfully.",
            'customer' => $customer,
        ]);
    }

    /**
     * Toggle Customer Status (Active / Paused)
     */
    public function toggleCustomerStatus(Request $request, $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        $customer->status = ($customer->status === 'active') ? 'paused' : 'active';
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => "Customer status updated to {$customer->status}.",
            'status' => $customer->status,
        ]);
    }

    /**
     * Daily Shift Milk Entry Roster
     */
    public function milkEntryRoster(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $shift = $request->input('shift', 'morning');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $customers = Customer::where('dairy_id', $dairy->id)
            ->where('status', 'active')
            ->orderBy('customer_code')
            ->get();

        $roster = $customers->map(function ($c) use ($date, $shift) {
            $rec = MilkRecord::where('customer_id', $c->id)
                ->whereDate('date', $date)
                ->where('shift', $shift)
                ->first();

            return [
                'customer_id' => $c->id,
                'customer_code' => $c->customer_code,
                'name' => $c->name,
                'area' => $c->area,
                'default_quantity' => (float) $c->daily_quantity,
                'recorded_quantity' => $rec ? (float) $rec->quantity : (float) $c->daily_quantity,
                'milk_type' => $c->milk_type,
                'rate' => (float) $c->rate_per_litre,
                'status' => $rec ? $rec->status : 'delivered',
                'record_id' => $rec ? $rec->id : null,
            ];
        });

        $totalLitres = $roster->where('status', 'delivered')->sum('recorded_quantity');

        return response()->json([
            'success' => true,
            'shift' => $shift,
            'date' => $date,
            'total_litres' => (float) $totalLitres,
            'roster' => $roster,
        ]);
    }

    /**
     * Save / Update Single Milk Entry
     */
    public function saveMilkEntry(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $customerId = $request->input('customer_id');
        $shift = $request->input('shift', 'morning');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $quantity = (float) $request->input('quantity', 2.0);
        $status = $request->input('status', 'delivered');

        $customer = Customer::findOrFail($customerId);

        $record = MilkRecord::updateOrCreate(
            [
                'dairy_id' => $dairy->id,
                'customer_id' => $customer->id,
                'date' => $date,
                'shift' => $shift,
            ],
            [
                'quantity' => ($status === 'paused' || $status === 'absent') ? 0.0 : $quantity,
                'milk_type' => $customer->milk_type,
                'rate' => $customer->rate_per_litre,
                'amount' => ($status === 'paused' || $status === 'absent') ? 0.0 : ($quantity * $customer->rate_per_litre),
                'status' => $status,
                'notes' => 'Recorded via Dairy Admin Mobile App',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Milk entry saved successfully',
            'record' => $record,
        ]);
    }

    /**
     * Batch Mark All Shift Deliveries
     */
    public function batchMarkDelivered(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $shift = $request->input('shift', 'morning');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $customers = Customer::where('dairy_id', $dairy->id)
            ->where('status', 'active')
            ->get();

        $count = 0;
        foreach ($customers as $c) {
            MilkRecord::updateOrCreate(
                [
                    'dairy_id' => $dairy->id,
                    'customer_id' => $c->id,
                    'date' => $date,
                    'shift' => $shift,
                ],
                [
                    'quantity' => (float) $c->daily_quantity,
                    'milk_type' => $c->milk_type,
                    'rate' => (float) $c->rate_per_litre,
                    'amount' => (float) ($c->daily_quantity * $c->rate_per_litre),
                    'status' => 'delivered',
                    'notes' => 'Batch marked via Dairy Admin Mobile App',
                ]
            );
            $count++;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully marked {$count} customer deliveries for {$shift} shift.",
        ]);
    }

    /**
     * Customer Invoices & Billing
     */
    public function bills(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);

        $bills = Bill::with('customer')
            ->where('dairy_id', $dairy->id)
            ->latest()
            ->take(30)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'bill_number' => $b->bill_number,
                    'customer_name' => $b->customer->name ?? 'Customer',
                    'customer_code' => $b->customer->customer_code ?? 'CUST-101',
                    'month_year' => $b->month_year,
                    'total_litres' => (float) $b->total_litres,
                    'total_amount' => (float) $b->total_amount,
                    'paid_amount' => (float) $b->paid_amount,
                    'pending_amount' => (float) $b->pending_amount,
                    'status' => $b->status,
                    'due_date' => $b->due_date ? $b->due_date->format('d M Y') : '15 Sep 2026',
                ];
            });

        return response()->json([
            'success' => true,
            'bills' => $bills,
            'summary' => [
                'total_billed' => $bills->sum('total_amount'),
                'total_collected' => $bills->sum('paid_amount'),
                'total_pending' => $bills->sum('pending_amount'),
            ]
        ]);
    }

    /**
     * Generate Monthly Bills Batch
     */
    public function generateBills(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $month = $request->input('month', 'September 2026');

        $customers = Customer::where('dairy_id', $dairy->id)->get();
        $generatedCount = 0;

        foreach ($customers as $c) {
            $litres = (float) $c->daily_quantity * 29;
            $subtotal = $litres * (float) $c->rate_per_litre;
            $billNum = 'BILL-' . date('Y') . '-' . rand(1000, 9999);

            Bill::updateOrCreate(
                [
                    'dairy_id' => $dairy->id,
                    'customer_id' => $c->id,
                    'month_year' => $month,
                ],
                [
                    'bill_number' => $billNum,
                    'total_litres' => $litres,
                    'milk_rate' => $c->rate_per_litre,
                    'subtotal' => $subtotal,
                    'additional_products_amount' => 0.0,
                    'discount_amount' => 0.0,
                    'total_amount' => $subtotal,
                    'paid_amount' => 0.0,
                    'pending_amount' => $subtotal,
                    'status' => 'pending',
                    'due_date' => Carbon::now()->addDays(10),
                ]
            );
            $generatedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "Generated {$generatedCount} bills for {$month}.",
        ]);
    }

    /**
     * Record Offline Cash or UPI Payment
     */
    public function recordPayment(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $customerId = $request->input('customer_id');
        $customer = Customer::findOrFail($customerId);

        $amount = (float) $request->input('amount', 1000.0);
        $method = $request->input('payment_method', 'cash'); // cash, upi, cheque
        $txId = 'PAY-' . date('Ymd') . rand(1000, 9999);

        $bill = Bill::where('customer_id', $customer->id)->where('status', '!=', 'paid')->latest()->first();

        $payment = Payment::create([
            'dairy_id' => $dairy->id,
            'customer_id' => $customer->id,
            'bill_id' => $bill ? $bill->id : null,
            'transaction_id' => $txId,
            'reference_no' => strtoupper($method) . '-' . rand(100000, 999999),
            'type' => 'bill',
            'amount' => $amount,
            'payment_method' => $method,
            'payment_date' => Carbon::now(),
            'status' => 'approved',
            'notes' => $request->input('notes', 'Recorded via Dairy Admin Mobile App'),
        ]);

        if ($bill) {
            $bill->paid_amount += $amount;
            $bill->pending_amount = max(0, $bill->total_amount - $bill->paid_amount);
            $bill->status = ($bill->pending_amount <= 0) ? 'paid' : 'partial';
            $bill->save();
        }

        return response()->json([
            'success' => true,
            'message' => "Payment of ₹{$amount} recorded for {$customer->name}.",
            'payment' => $payment,
        ]);
    }

    /**
     * Customer Vacation Pause / Extra Milk Requests & Tickets
     */
    public function requests(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);

        $tickets = SupportTicket::with('customer')
            ->where('dairy_id', $dairy->id)
            ->latest()
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'ticket_number' => $t->ticket_number,
                    'customer_name' => $t->customer->name ?? 'Rajesh Sharma',
                    'customer_code' => $t->customer->customer_code ?? 'CUST-101',
                    'customer_phone' => $t->customer->phone ?? '+91 98930 11223',
                    'subject' => $t->subject,
                    'message' => $t->message,
                    'status' => $t->status,
                    'reply' => $t->reply,
                    'created_at' => $t->created_at->format('d M Y, h:i A'),
                ];
            });

        return response()->json([
            'success' => true,
            'requests' => $tickets,
        ]);
    }

    /**
     * Approve or Reject Customer Request
     */
    public function updateRequestStatus(Request $request, $id): JsonResponse
    {
        $ticket = SupportTicket::findOrFail($id);
        $action = $request->input('action', 'approve'); // approve, reject
        $reply = $request->input('reply', $action === 'approve' ? 'Approved by Dairy Admin' : 'Rejected');

        $ticket->status = ($action === 'approve') ? 'resolved' : 'closed';
        $ticket->reply = $reply;
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => "Request has been {$action}d.",
            'status' => $ticket->status,
        ]);
    }

    /**
     * Dairy Products & Rates
     */
    public function products(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);
        $products = Product::where('dairy_id', $dairy->id)->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'unit' => $p->unit ?? 'Litre',
                'stock' => (float) ($p->stock_quantity ?? 100),
                'status' => $p->status ?? 'active',
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Add or Update Product
     */
    public function storeProduct(Request $request): JsonResponse
    {
        $dairy = $this->getTenantDairy($request);

        $product = Product::updateOrCreate(
            [
                'id' => $request->id,
                'dairy_id' => $dairy->id,
            ],
            [
                'name' => $request->name,
                'price' => (float) $request->price,
                'unit' => $request->unit ?? 'Litre',
                'stock_quantity' => (float) ($request->stock ?? 100),
                'status' => 'active',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }
}
