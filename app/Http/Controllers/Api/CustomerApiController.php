<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\MilkRecord;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerApiController extends Controller
{
    /**
     * Customer Mobile Login
     */
    public function login(Request $request): JsonResponse
    {
        $login = $request->input('login', 'customer@milkflow.demo');
        $password = $request->input('password', 'password');

        $user = User::where('email', $login)
            ->orWhere('phone', $login)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            // For demo convenience, fallback to Rajesh Sharma if demo credentials matched
            if ($login === 'customer@milkflow.demo' || $login === '9893011223') {
                $user = User::where('role', 'customer')->first();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid mobile number/email or password.'
                ], 401);
            }
        }

        $customer = Customer::with('dairy')->where('user_id', $user->id)->first()
            ?? Customer::with('dairy')->where('customer_code', 'CUST-101')->first()
            ?? Customer::with('dairy')->first();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => 'demo_bearer_token_' . Str::random(32),
            'customer' => [
                'id' => $customer->id,
                'customer_code' => $customer->customer_code,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => $customer->address,
                'area' => $customer->area,
                'daily_quantity' => (float) $customer->daily_quantity,
                'milk_type' => $customer->milk_type,
                'delivery_time' => $customer->delivery_time,
                'rate_per_litre' => (float) $customer->rate_per_litre,
                'status' => $customer->status,
                'dairy_name' => $customer->dairy->name ?? 'Shree Krishna Dairy',
                'dairy_phone' => $customer->dairy->phone ?? '+91 98260 12345',
            ]
        ]);
    }

    /**
     * Customer Dashboard Data
     */
    public function dashboard(Request $request, $id = null): JsonResponse
    {
        $customer = $id ? Customer::with('dairy')->find($id) : Customer::with('dairy')->where('customer_code', 'CUST-101')->first();
        if (!$customer) {
            $customer = Customer::with('dairy')->first();
        }

        $today = Carbon::today();
        $todayRecord = MilkRecord::where('customer_id', $customer->id)
            ->whereDate('date', $today)
            ->first();

        $monthlyLitres = MilkRecord::where('customer_id', $customer->id)
            ->whereMonth('date', $today->month)
            ->where('status', 'delivered')
            ->sum('quantity') ?: 58.0;

        $currentBill = Bill::where('customer_id', $customer->id)
            ->latest()
            ->first();

        $recentRecords = MilkRecord::where('customer_id', $customer->id)
            ->latest('date')
            ->take(7)
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'date' => $r->date->format('Y-m-d'),
                    'formatted_date' => $r->date->format('D, d M'),
                    'shift' => $r->shift,
                    'quantity' => (float) $r->quantity,
                    'milk_type' => $r->milk_type,
                    'rate' => (float) $r->rate,
                    'amount' => (float) $r->amount,
                    'status' => $r->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'customer_code' => $customer->customer_code,
                    'dairy_name' => $customer->dairy->name ?? 'Shree Krishna Dairy',
                    'dairy_phone' => $customer->dairy->phone ?? '+91 98260 12345',
                ],
                'today' => [
                    'quantity' => $todayRecord ? (float) $todayRecord->quantity : (float) $customer->daily_quantity,
                    'milk_type' => $customer->milk_type,
                    'status' => $todayRecord ? $todayRecord->status : 'delivered',
                    'delivered_time' => '06:45 AM',
                    'delivery_boy' => 'Suresh Parmar',
                ],
                'month_stats' => [
                    'total_litres' => (float) $monthlyLitres,
                    'month_name' => 'September 2026',
                    'bill_total' => $currentBill ? (float) $currentBill->total_amount : 3880.0,
                    'paid_amount' => $currentBill ? (float) $currentBill->paid_amount : 2400.0,
                    'pending_amount' => $currentBill ? (float) $currentBill->pending_amount : 1480.0,
                    'bill_status' => $currentBill ? $currentBill->status : 'partial',
                    'bill_id' => $currentBill ? $currentBill->id : 1,
                    'due_date' => $currentBill ? $currentBill->due_date->format('d M Y') : '13 Sep 2026',
                ],
                'recent_records' => $recentRecords,
            ]
        ]);
    }

    /**
     * Milk History Records
     */
    public function milkRecords(Request $request, $id = null): JsonResponse
    {
        $customerId = $id ?? Customer::where('customer_code', 'CUST-101')->value('id') ?? 1;

        $records = MilkRecord::where('customer_id', $customerId)
            ->latest('date')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'date' => $r->date->format('Y-m-d'),
                    'formatted_date' => $r->date->format('l, d M Y'),
                    'day' => $r->date->format('d'),
                    'day_name' => $r->date->format('D'),
                    'shift' => $r->shift,
                    'quantity' => (float) $r->quantity,
                    'milk_type' => $r->milk_type,
                    'rate' => (float) $r->rate,
                    'amount' => (float) $r->amount,
                    'status' => $r->status,
                ];
            });

        return response()->json([
            'success' => true,
            'records' => $records,
            'summary' => [
                'total_litres' => $records->where('status', 'delivered')->sum('quantity'),
                'month' => 'September 2026',
            ]
        ]);
    }

    /**
     * Customer Bills
     */
    public function bills(Request $request, $id = null): JsonResponse
    {
        $customerId = $id ?? Customer::where('customer_code', 'CUST-101')->value('id') ?? 1;

        $bills = Bill::where('customer_id', $customerId)
            ->latest()
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'bill_number' => $b->bill_number,
                    'month_year' => $b->month_year,
                    'total_litres' => (float) $b->total_litres,
                    'milk_rate' => (float) $b->milk_rate,
                    'subtotal' => (float) $b->subtotal,
                    'additional_products_amount' => (float) $b->additional_products_amount,
                    'discount_amount' => (float) $b->discount_amount,
                    'total_amount' => (float) $b->total_amount,
                    'paid_amount' => (float) $b->paid_amount,
                    'pending_amount' => (float) $b->pending_amount,
                    'status' => $b->status,
                    'due_date' => $b->due_date->format('d M Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'bills' => $bills,
        ]);
    }

    /**
     * Process Instant Payment via App
     */
    public function pay(Request $request): JsonResponse
    {
        $customerId = $request->input('customer_id') 
            ?? Customer::where('customer_code', 'CUST-101')->value('id') 
            ?? 1;
        $customer = Customer::findOrFail($customerId);

        $bill = null;
        if ($request->filled('bill_id')) {
            $bill = Bill::where('customer_id', $customer->id)->find($request->bill_id);
        } else {
            $bill = Bill::where('customer_id', $customer->id)->where('status', '!=', 'paid')->latest()->first();
        }

        $amount = (float) ($request->amount ?? ($bill ? $bill->pending_amount : 1480.00));
        $rawMethod = strtolower($request->payment_method ?? 'upi');
        $validMethods = ['cash', 'online', 'upi', 'bank_transfer', 'cheque'];
        $method = in_array($rawMethod, $validMethods) ? $rawMethod : 'upi';
        $txId = 'MF' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $payment = Payment::create([
            'transaction_id' => $txId,
            'reference_no' => strtoupper($method) . '/' . rand(10000000, 99999999),
            'dairy_id' => $customer->dairy_id,
            'customer_id' => $customer->id,
            'bill_id' => $bill ? $bill->id : null,
            'type' => 'bill',
            'amount' => $amount,
            'payment_method' => $method,
            'payment_date' => Carbon::now(),
            'status' => 'approved',
            'notes' => 'Flutter Mobile App Instant UPI Payment',
        ]);

        if ($bill) {
            $bill->paid_amount += $amount;
            $bill->pending_amount = max(0, $bill->total_amount - $bill->paid_amount);
            $bill->status = ($bill->pending_amount <= 0) ? 'paid' : 'partial';
            $bill->save();
        }

        // Notification for Dairy Admin
        Notification::create([
            'dairy_id' => $customer->dairy_id,
            'title' => "Mobile UPI Payment Received: ₹{$amount}",
            'message' => "Customer {$customer->name} paid ₹{$amount} online via Flutter Mobile App ({$method}). TxID: {$txId}",
            'type' => 'success',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'receipt' => [
                'transaction_id' => $txId,
                'amount' => $amount,
                'method' => $method,
                'payment_date' => Carbon::now()->format('d M Y, h:i A'),
                'bill_status' => $bill ? strtoupper($bill->status) : 'PAID',
                'remaining_due' => $bill ? (float) $bill->pending_amount : 0.0,
                'dairy_name' => $customer->dairy->name ?? 'Shree Krishna Dairy',
            ]
        ]);
    }

    /**
     * Request Schedule Pause or Extra Milk
     */
    public function requestSchedule(Request $request): JsonResponse
    {
        $customerId = $request->input('customer_id') 
            ?? Customer::where('customer_code', 'CUST-101')->value('id') 
            ?? 1;
        $customer = Customer::findOrFail($customerId);

        $type = $request->input('request_type', 'pause');
        $subject = $type === 'pause'
            ? "Vacation Pause Request: {$request->start_date} to {$request->end_date}"
            : "Extra Milk Request: {$request->new_quantity}L on {$request->effective_date}";

        $ticket = SupportTicket::create([
            'dairy_id' => $customer->dairy_id,
            'customer_id' => $customer->id,
            'ticket_number' => 'APP-REQ-' . rand(1000, 9999),
            'subject' => $subject,
            'message' => $request->reason ?? 'Submitted via Customer Flutter App.',
            'status' => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your request has been submitted to your dairy. You will receive an SMS confirmation once approved.',
            'ticket_id' => $ticket->ticket_number,
        ]);
    }

    /**
     * Customer Support Tickets
     */
    public function supportTickets(Request $request, $id = null): JsonResponse
    {
        $customerId = $id ?? Customer::where('customer_code', 'CUST-101')->value('id') ?? 1;

        $tickets = SupportTicket::where('customer_id', $customerId)
            ->latest()
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'ticket_number' => $t->ticket_number,
                    'subject' => $t->subject,
                    'message' => $t->message,
                    'status' => $t->status,
                    'reply' => $t->reply,
                    'created_at' => $t->created_at->format('d M Y, h:i A'),
                ];
            });

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
        ]);
    }

    /**
     * Submit Support Ticket
     */
    public function createTicket(Request $request): JsonResponse
    {
        $customerId = $request->input('customer_id') 
            ?? Customer::where('customer_code', 'CUST-101')->value('id') 
            ?? 1;
        $customer = Customer::findOrFail($customerId);

        $ticket = SupportTicket::create([
            'dairy_id' => $customer->dairy_id,
            'customer_id' => $customer->id,
            'ticket_number' => 'TCK-' . date('Y') . '-' . rand(100, 999),
            'subject' => $request->input('subject', 'General Inquiry'),
            'message' => $request->input('message', 'Message from app user'),
            'status' => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Support ticket submitted successfully.',
            'ticket' => [
                'ticket_number' => $ticket->ticket_number,
                'subject' => $ticket->subject,
                'status' => $ticket->status,
            ]
        ]);
    }
}
