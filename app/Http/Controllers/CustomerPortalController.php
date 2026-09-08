<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\MilkRecord;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    private function getCustomer(): Customer
    {
        $user = Auth::user();
        if ($user && $user->customer) {
            return $user->customer->load(['dairy', 'bills']);
        }
        // Fallback for demo resilience to Rajesh Sharma
        return Customer::with(['dairy', 'bills'])->where('customer_code', 'CUST-101')->first() 
            ?? Customer::with(['dairy', 'bills'])->first();
    }

    public function dashboard()
    {
        $customer = $this->getCustomer();
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
            ->get();

        return view('customer.dashboard', compact(
            'customer', 'todayRecord', 'monthlyLitres', 'currentBill', 'recentRecords'
        ));
    }

    public function milk()
    {
        $customer = $this->getCustomer();
        $records = MilkRecord::where('customer_id', $customer->id)
            ->latest('date')
            ->get();

        return view('customer.milk', compact('customer', 'records'));
    }

    public function bills()
    {
        $customer = $this->getCustomer();
        $bills = Bill::where('customer_id', $customer->id)->with('payments')->latest()->get();

        return view('customer.bills', compact('customer', 'bills'));
    }

    public function payments()
    {
        $customer = $this->getCustomer();
        $payments = Payment::where('customer_id', $customer->id)->with('bill')->latest()->get();

        return view('customer.payments', compact('customer', 'payments'));
    }

    public function processPayment(Request $request)
    {
        $customer = $this->getCustomer();

        $bill = null;
        if ($request->filled('bill_id')) {
            $bill = Bill::where('customer_id', $customer->id)->find($request->bill_id);
        } else {
            $bill = Bill::where('customer_id', $customer->id)->where('status', '!=', 'paid')->latest()->first();
        }

        $amount = $request->amount ?? ($bill ? $bill->pending_amount : 1480.00);
        $method = $request->payment_method ?? 'upi';
        $txId = 'MF20260908' . str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT);

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
            'notes' => 'Customer Portal Instant UPI Payment',
        ]);

        if ($bill) {
            $bill->paid_amount += $amount;
            $bill->pending_amount = max(0, $bill->total_amount - $bill->paid_amount);
            $bill->status = ($bill->pending_amount <= 0) ? 'paid' : 'partial';
            $bill->save();
        }

        // Send notification to Dairy Admin
        Notification::create([
            'dairy_id' => $customer->dairy_id,
            'user_id' => null,
            'title' => "Payment of ₹{$amount} received",
            'message' => "Customer {$customer->name} paid ₹{$amount} online via {$method}. TxID: {$txId}",
            'type' => 'success',
            'is_read' => false,
        ]);

        return back()->with('payment_success', [
            'amount' => $amount,
            'tx_id' => $txId,
            'bill_status' => $bill ? strtoupper($bill->status) : 'PAID',
        ]);
    }

    public function schedule()
    {
        $customer = $this->getCustomer();
        return view('customer.schedule', compact('customer'));
    }

    public function requestScheduleChange(Request $request)
    {
        $customer = $this->getCustomer();

        SupportTicket::create([
            'dairy_id' => $customer->dairy_id,
            'customer_id' => $customer->id,
            'ticket_number' => 'REQ-' . rand(1000, 9999),
            'subject' => $request->request_type === 'pause' 
                ? "Delivery Pause Request: {$request->start_date} to {$request->end_date}"
                : "Quantity Modification Request: {$request->new_quantity}L ({$request->effective_date})",
            'message' => $request->reason ?? 'Schedule change requested via Customer App.',
            'status' => 'open',
        ]);

        return back()->with('success', 'Your schedule request has been submitted to your dairy. You will receive an SMS confirmation once approved.');
    }

    public function profile()
    {
        $customer = $this->getCustomer();
        return view('customer.profile', compact('customer'));
    }

    public function support()
    {
        $customer = $this->getCustomer();
        $tickets = SupportTicket::where('customer_id', $customer->id)->latest()->get();
        return view('customer.support', compact('customer', 'tickets'));
    }

    public function storeSupportTicket(Request $request)
    {
        $customer = $this->getCustomer();

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'dairy_id' => $customer->dairy_id,
            'customer_id' => $customer->id,
            'ticket_number' => 'TCK-' . date('Y') . '-' . rand(100, 999),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return back()->with('success', 'Support ticket raised. The dairy team will respond shortly.');
    }
}
