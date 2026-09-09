<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Dairy;
use App\Models\MilkRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiMobileAppsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test Customer Mobile App API Endpoints
     */
    public function test_customer_mobile_api_flows(): void
    {
        // 1. Customer Login
        $loginRes = $this->postJson('/api/customer/login', [
            'login' => 'customer@milkflow.demo',
            'password' => 'password',
        ]);
        $loginRes->assertStatus(200)
            ->assertJson(['success' => true]);

        // 2. Customer Dashboard
        $dashRes = $this->getJson('/api/customer/dashboard/1');
        $dashRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'data' => [
                    'customer' => ['name', 'customer_code', 'dairy_name'],
                    'today' => ['quantity', 'status'],
                    'month_stats' => ['total_litres', 'bill_total', 'pending_amount'],
                ]
            ]);

        // 3. Customer Milk Records
        $milkRes = $this->getJson('/api/customer/milk/1');
        $milkRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['records', 'summary']);

        // 4. Customer Bills
        $billsRes = $this->getJson('/api/customer/bills/1');
        $billsRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['bills']);

        // 5. Instant UPI Payment Simulation
        $payRes = $this->postJson('/api/customer/pay', [
            'customer_id' => 1,
            'amount' => 500.0,
            'payment_method' => 'gpay',
        ]);
        $payRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'receipt' => ['transaction_id', 'amount', 'method', 'bill_status']
            ]);

        // 6. Vacation Pause Request
        $schedRes = $this->postJson('/api/customer/schedule', [
            'customer_id' => 1,
            'request_type' => 'pause',
            'start_date' => '2026-09-15',
            'end_date' => '2026-09-18',
            'reason' => 'Visiting hometown',
        ]);
        $schedRes->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * Test Dairy Admin Mobile App API Endpoints
     */
    public function test_dairy_admin_mobile_api_flows(): void
    {
        // 1. Dairy Admin Login
        $loginRes = $this->postJson('/api/dairy/login', [
            'login' => 'dairy@milkflow.demo',
            'password' => 'password',
        ]);
        $loginRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'admin' => ['name', 'dairy_name', 'plan_name']
            ]);

        // 2. Dashboard KPIs
        $dashRes = $this->getJson('/api/dairy/dashboard?dairy_id=1');
        $dashRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'data' => [
                    'dairy' => ['name', 'owner_name', 'plan'],
                    'kpis' => ['total_litres_today', 'delivered_litres', 'today_revenue', 'pending_payments'],
                    'shifts' => ['morning', 'evening'],
                ]
            ]);

        // 3. Customer Directory
        $custRes = $this->getJson('/api/dairy/customers?dairy_id=1');
        $custRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['customers', 'areas']);

        // 4. Daily Shift Milk Entry Roster
        $rosterRes = $this->getJson('/api/dairy/milk-entry?dairy_id=1&shift=morning&date=2026-09-09');
        $rosterRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['shift', 'date', 'roster']);

        // 5. Save Single Customer Milk Entry
        $saveRes = $this->postJson('/api/dairy/milk-entry/save', [
            'dairy_id' => 1,
            'customer_id' => 1,
            'shift' => 'morning',
            'date' => '2026-09-09',
            'quantity' => 2.5,
            'status' => 'delivered',
        ]);
        $saveRes->assertStatus(200)
            ->assertJson(['success' => true]);

        // 6. Record Offline Cash/UPI Payment
        $payRes = $this->postJson('/api/dairy/payments/record', [
            'dairy_id' => 1,
            'customer_id' => 1,
            'amount' => 1000.0,
            'payment_method' => 'cash',
            'notes' => 'Received by delivery boy',
        ]);
        $payRes->assertStatus(200)
            ->assertJson(['success' => true]);

        // 7. Products Catalog
        $prodRes = $this->getJson('/api/dairy/products?dairy_id=1');
        $prodRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['products']);
    }
}
