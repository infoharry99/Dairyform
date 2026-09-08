<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dairy;
use App\Models\MilkRecord;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Subscription Plans
        $basicPlan = SubscriptionPlan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'tagline' => 'Essential tools for small village milk centers',
            'price_monthly' => 499,
            'price_half_yearly' => 2699,
            'price_yearly' => 4999,
            'customer_limit' => 100,
            'staff_limit' => 2,
            'features' => [
                'Up to 100 Customers',
                'Daily Milk Quantity Tracking',
                'Basic Monthly Billing & Invoices',
                'Manual Payment Tracking (Cash)',
                'Standard Mobile Responsive View',
                'Community Email Support',
            ],
            'is_popular' => false,
        ]);

        $standardPlan = SubscriptionPlan::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'tagline' => 'The complete operating system for growing dairy shops',
            'price_monthly' => 999,
            'price_half_yearly' => 5399,
            'price_yearly' => 9999,
            'customer_limit' => 500,
            'staff_limit' => 6,
            'features' => [
                'Up to 500 Customers',
                'Morning & Evening Shift Tracking',
                'Automated WhatsApp Bill Alerts',
                'Online UPI & QR Code Payments',
                'Customer Self-Service Web App',
                'Additional Dairy Products Catalog',
                'Delivery Boy Route Management',
                'Priority Phone & WhatsApp Support',
            ],
            'is_popular' => true,
        ]);

        $premiumPlan = SubscriptionPlan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'tagline' => 'Enterprise automation for large milk suppliers & chains',
            'price_monthly' => 1999,
            'price_half_yearly' => 10799,
            'price_yearly' => 19999,
            'customer_limit' => 2000,
            'staff_limit' => 20,
            'features' => [
                'Unlimited Customers',
                'Multi-Route GPS Delivery Tracking',
                'Automated Payment Reconciliation',
                'Fat & SNF Milk Rate Calculator',
                'Complete Inventory & Expiry Tracking',
                'Accountant & Manager Multi-Staff Roles',
                'Automated PDF & Excel Reporting',
                'Dedicated Account Manager (24/7)',
            ],
            'is_popular' => false,
        ]);

        // 2. Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@milkflow.demo',
            'phone' => '+91 98260 00001',
            'role' => 'super_admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // 3. Create Demo Dairies
        // Dairy 1: Shree Krishna Dairy (Flagship Tenant - Active)
        $shreeKrishna = Dairy::create([
            'name' => 'Shree Krishna Dairy',
            'slug' => 'shree-krishna-dairy',
            'owner_name' => 'Rajesh Patel',
            'email' => 'dairy@milkflow.demo',
            'phone' => '+91 98260 12345',
            'city' => 'Indore',
            'address' => 'Plot 42, Annapurna Road, Near Mandir, Indore, MP 452009',
            'status' => 'active',
        ]);

        Subscription::create([
            'dairy_id' => $shreeKrishna->id,
            'plan_id' => $standardPlan->id,
            'billing_cycle' => 'yearly',
            'amount' => 9999.00,
            'starts_at' => Carbon::now()->subMonths(2),
            'expires_at' => Carbon::now()->addMonths(10),
            'status' => 'active',
            'auto_renew' => true,
        ]);

        $dairyAdmin = User::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Rajesh Patel',
            'email' => 'dairy@milkflow.demo',
            'phone' => '+91 98260 12345',
            'role' => 'dairy_admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        // Dairy 2: Fresh Milk Dairy (Bhopal - Active)
        $freshMilk = Dairy::create([
            'name' => 'Fresh Milk Dairy',
            'slug' => 'fresh-milk-dairy',
            'owner_name' => 'Amit Verma',
            'email' => 'amit@freshmilk.demo',
            'phone' => '+91 98260 23456',
            'city' => 'Bhopal',
            'address' => '12 Arera Colony, Near Bittan Market, Bhopal, MP',
            'status' => 'active',
        ]);

        Subscription::create([
            'dairy_id' => $freshMilk->id,
            'plan_id' => $premiumPlan->id,
            'billing_cycle' => 'yearly',
            'amount' => 19999.00,
            'starts_at' => Carbon::now()->subMonths(1),
            'expires_at' => Carbon::now()->addMonths(11),
            'status' => 'active',
            'auto_renew' => true,
        ]);

        // Dairy 3: Annapurna Dairy (Ujjain - Pending Approval)
        $annapurna = Dairy::create([
            'name' => 'Annapurna Dairy',
            'slug' => 'annapurna-dairy',
            'owner_name' => 'Ramesh Joshi',
            'email' => 'ramesh@annapurna.demo',
            'phone' => '+91 98260 34567',
            'city' => 'Ujjain',
            'address' => '78 Freeganj Main Road, Ujjain, MP',
            'status' => 'pending',
        ]);

        $annapurnaSub = Subscription::create([
            'dairy_id' => $annapurna->id,
            'plan_id' => $basicPlan->id,
            'billing_cycle' => 'monthly',
            'amount' => 499.00,
            'starts_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonth(),
            'status' => 'pending',
            'auto_renew' => false,
        ]);

        Payment::create([
            'transaction_id' => 'SUB-AP-20260901',
            'reference_no' => 'UPI/2948291048',
            'dairy_id' => $annapurna->id,
            'subscription_id' => $annapurnaSub->id,
            'type' => 'subscription',
            'amount' => 499.00,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now()->subHours(4),
            'status' => 'pending',
            'notes' => 'GPay reference: UPI/2948291048 by Ramesh Joshi',
        ]);

        // Dairy 4: Radha Dairy (Dewas - Expiring Soon)
        $radha = Dairy::create([
            'name' => 'Radha Dairy',
            'slug' => 'radha-dairy',
            'owner_name' => 'Suresh Sharma',
            'email' => 'suresh@radhadairy.demo',
            'phone' => '+91 98260 45678',
            'city' => 'Dewas',
            'address' => 'Station Road, Dewas, MP',
            'status' => 'active',
        ]);

        Subscription::create([
            'dairy_id' => $radha->id,
            'plan_id' => $standardPlan->id,
            'billing_cycle' => 'monthly',
            'amount' => 999.00,
            'starts_at' => Carbon::now()->subDays(26),
            'expires_at' => Carbon::now()->addDays(4),
            'status' => 'expiring_soon',
            'auto_renew' => true,
        ]);

        // Dairy 5: Maa Narmada Dairy (Rau - Expired)
        $maaNarmada = Dairy::create([
            'name' => 'Maa Narmada Dairy',
            'slug' => 'maa-narmada-dairy',
            'owner_name' => 'Vikram Singh',
            'email' => 'vikram@maanarmada.demo',
            'phone' => '+91 98260 56789',
            'city' => 'Rau',
            'address' => 'AB Road, Near Rau Circle, Indore, MP',
            'status' => 'expired',
        ]);

        Subscription::create([
            'dairy_id' => $maaNarmada->id,
            'plan_id' => $basicPlan->id,
            'billing_cycle' => 'monthly',
            'amount' => 499.00,
            'starts_at' => Carbon::now()->subMonths(2),
            'expires_at' => Carbon::now()->subDays(5),
            'status' => 'expired',
            'auto_renew' => false,
        ]);

        // 4. Products for Shree Krishna Dairy
        $products = [
            ['name' => 'Cow Milk (Fresh & Chilled)', 'category' => 'milk', 'price' => 60.00, 'unit' => 'L', 'stock' => 250, 'status' => 'in_stock'],
            ['name' => 'Buffalo Milk (Pure Thick)', 'category' => 'milk', 'price' => 72.00, 'unit' => 'L', 'stock' => 180, 'status' => 'in_stock'],
            ['name' => 'Fresh Curd / Dahi', 'category' => 'curd', 'price' => 80.00, 'unit' => 'kg', 'stock' => 45, 'status' => 'in_stock'],
            ['name' => 'Desi Malai Paneer', 'category' => 'paneer', 'price' => 360.00, 'unit' => 'kg', 'stock' => 25, 'status' => 'in_stock'],
            ['name' => 'Pure Desi Danedar Ghee', 'category' => 'ghee', 'price' => 650.00, 'unit' => 'L', 'stock' => 60, 'status' => 'in_stock'],
            ['name' => 'Fresh White Butter (Makkhan)', 'category' => 'butter', 'price' => 520.00, 'unit' => 'kg', 'stock' => 15, 'status' => 'in_stock'],
            ['name' => 'Spiced Masala Buttermilk (Chaas)', 'category' => 'buttermilk', 'price' => 20.00, 'unit' => 'packet', 'stock' => 100, 'status' => 'in_stock'],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['dairy_id' => $shreeKrishna->id]));
        }

        // 5. Staff for Shree Krishna Dairy
        Staff::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Suresh Parmar',
            'phone' => '+91 97555 11223',
            'role' => 'delivery_boy',
            'assigned_area' => 'Scheme 54 & Vijay Nagar',
            'permissions' => ['view_route', 'mark_delivery'],
            'status' => 'active',
        ]);

        Staff::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Kamlesh Yadav',
            'phone' => '+91 97555 22334',
            'role' => 'delivery_boy',
            'assigned_area' => 'Palasia & Rau',
            'permissions' => ['view_route', 'mark_delivery'],
            'status' => 'active',
        ]);

        Staff::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Manish Saxena',
            'phone' => '+91 97555 33445',
            'role' => 'accountant',
            'assigned_area' => 'Accounts Office',
            'permissions' => ['billing', 'payments', 'reports'],
            'status' => 'active',
        ]);

        Staff::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Ritu Dave',
            'phone' => '+91 97555 44556',
            'role' => 'manager',
            'assigned_area' => 'All Operations',
            'permissions' => ['customers', 'milk', 'billing', 'reports'],
            'status' => 'active',
        ]);

        // 6. Customers for Shree Krishna Dairy
        // Target customer Rajesh Sharma (Customer portal demo user)
        $customerUser = User::create([
            'dairy_id' => $shreeKrishna->id,
            'name' => 'Rajesh Sharma',
            'email' => 'customer@milkflow.demo',
            'phone' => '+91 98930 11223',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        $rajeshCustomer = Customer::create([
            'dairy_id' => $shreeKrishna->id,
            'user_id' => $customerUser->id,
            'customer_code' => 'CUST-101',
            'name' => 'Rajesh Sharma',
            'phone' => '+91 98930 11223',
            'email' => 'customer@milkflow.demo',
            'address' => 'Flat 302, Royal Palms, Scheme 54',
            'area' => 'Scheme 54',
            'daily_quantity' => 2.0,
            'milk_type' => 'cow',
            'delivery_time' => 'morning',
            'rate_per_litre' => 60.00,
            'status' => 'active',
            'start_date' => Carbon::now()->subMonths(6),
            'notes' => 'Ring bell twice and leave can in door holder.',
        ]);

        $otherCustomers = [
            [
                'customer_code' => 'CUST-102',
                'name' => 'Priya Verma',
                'phone' => '+91 98930 22334',
                'email' => 'priya.v@example.com',
                'address' => 'B-14 Silver Springs, Vijay Nagar',
                'area' => 'Vijay Nagar',
                'daily_quantity' => 1.5,
                'milk_type' => 'buffalo',
                'delivery_time' => 'morning',
                'rate_per_litre' => 72.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-103',
                'name' => 'Alok Nath',
                'phone' => '+91 98930 33445',
                'email' => 'alok.nath@example.com',
                'address' => '22 Anand Bazaar, Palasia',
                'area' => 'Palasia',
                'daily_quantity' => 3.0,
                'milk_type' => 'cow',
                'delivery_time' => 'both',
                'rate_per_litre' => 60.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-104',
                'name' => 'Meena Joshi',
                'phone' => '+91 98930 44556',
                'email' => 'meena.j@example.com',
                'address' => 'House 55, Green Valley, Rau',
                'area' => 'Rau',
                'daily_quantity' => 2.0,
                'milk_type' => 'buffalo',
                'delivery_time' => 'morning',
                'rate_per_litre' => 72.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-105',
                'name' => 'Deepak Tiwari',
                'phone' => '+91 98930 55667',
                'email' => 'deepak.t@example.com',
                'address' => '104 Galaxy Apts, Scheme 54',
                'area' => 'Scheme 54',
                'daily_quantity' => 1.0,
                'milk_type' => 'cow',
                'delivery_time' => 'evening',
                'rate_per_litre' => 60.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-106',
                'name' => 'Sunita Dubey',
                'phone' => '+91 98930 66778',
                'email' => 'sunita.d@example.com',
                'address' => 'C-8 Maple Woods, Vijay Nagar',
                'area' => 'Vijay Nagar',
                'daily_quantity' => 2.5,
                'milk_type' => 'mixed',
                'delivery_time' => 'morning',
                'rate_per_litre' => 65.00,
                'status' => 'paused',
            ],
            [
                'customer_code' => 'CUST-107',
                'name' => 'Sanjay Rathore',
                'phone' => '+91 98930 77889',
                'email' => 'sanjay.r@example.com',
                'address' => '401 Sapphire Heights, Palasia',
                'area' => 'Palasia',
                'daily_quantity' => 2.0,
                'milk_type' => 'cow',
                'delivery_time' => 'morning',
                'rate_per_litre' => 60.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-108',
                'name' => 'Anita Agarwal',
                'phone' => '+91 98930 88990',
                'email' => 'anita.a@example.com',
                'address' => 'Villa 12, Classic Colony, Scheme 54',
                'area' => 'Scheme 54',
                'daily_quantity' => 1.5,
                'milk_type' => 'buffalo',
                'delivery_time' => 'morning',
                'rate_per_litre' => 72.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-109',
                'name' => 'Rahul Chauhan',
                'phone' => '+91 98930 99001',
                'email' => 'rahul.c@example.com',
                'address' => 'Sector A, Vijay Nagar',
                'area' => 'Vijay Nagar',
                'daily_quantity' => 2.0,
                'milk_type' => 'cow',
                'delivery_time' => 'evening',
                'rate_per_litre' => 60.00,
                'status' => 'active',
            ],
            [
                'customer_code' => 'CUST-110',
                'name' => 'Kavita Malviya',
                'phone' => '+91 98930 12999',
                'email' => 'kavita.m@example.com',
                'address' => '31 Mahadev Colony, Rau',
                'area' => 'Rau',
                'daily_quantity' => 1.0,
                'milk_type' => 'cow',
                'delivery_time' => 'morning',
                'rate_per_litre' => 60.00,
                'status' => 'active',
            ],
        ];

        $allCustomerModels = [$rajeshCustomer];
        foreach ($otherCustomers as $c) {
            $created = Customer::create(array_merge($c, [
                'dairy_id' => $shreeKrishna->id,
                'start_date' => Carbon::now()->subMonths(rand(1, 12)),
            ]));
            $allCustomerModels[] = $created;
        }

        // 7. Milk Records for Today & Recent Days
        $today = Carbon::today();
        foreach ($allCustomerModels as $cust) {
            // Today Morning
            $isDelivered = in_array($cust->customer_code, ['CUST-101', 'CUST-102', 'CUST-103', 'CUST-104', 'CUST-107', 'CUST-108', 'CUST-110']);
            $isSkipped = ($cust->status === 'paused');
            $status = $isSkipped ? 'skipped' : ($isDelivered ? 'delivered' : 'pending');

            MilkRecord::create([
                'dairy_id' => $shreeKrishna->id,
                'customer_id' => $cust->id,
                'date' => $today,
                'shift' => 'morning',
                'quantity' => $cust->daily_quantity,
                'milk_type' => $cust->milk_type,
                'rate' => $cust->rate_per_litre,
                'amount' => $cust->daily_quantity * $cust->rate_per_litre,
                'status' => $status,
                'recorded_by' => 'Suresh Parmar',
            ]);

            // Today Evening (For evening / both customers)
            if (in_array($cust->delivery_time, ['evening', 'both'])) {
                MilkRecord::create([
                    'dairy_id' => $shreeKrishna->id,
                    'customer_id' => $cust->id,
                    'date' => $today,
                    'shift' => 'evening',
                    'quantity' => $cust->daily_quantity,
                    'milk_type' => $cust->milk_type,
                    'rate' => $cust->rate_per_litre,
                    'amount' => $cust->daily_quantity * $cust->rate_per_litre,
                    'status' => 'pending', // Evening delivery starts at 5 PM
                    'recorded_by' => 'Kamlesh Yadav',
                ]);
            }

            // Past 7 days records for realistic history & charts
            for ($d = 1; $d <= 7; $d++) {
                $pastDate = Carbon::today()->subDays($d);
                MilkRecord::create([
                    'dairy_id' => $shreeKrishna->id,
                    'customer_id' => $cust->id,
                    'date' => $pastDate,
                    'shift' => 'morning',
                    'quantity' => $cust->daily_quantity,
                    'milk_type' => $cust->milk_type,
                    'rate' => $cust->rate_per_litre,
                    'amount' => $cust->daily_quantity * $cust->rate_per_litre,
                    'status' => 'delivered',
                    'recorded_by' => 'Suresh Parmar',
                ]);
            }
        }

        // 8. Bills
        // Rajesh Sharma's September 2026 Bill
        $rajeshBill = Bill::create([
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $rajeshCustomer->id,
            'bill_number' => 'INV-202609-101',
            'month_year' => 'September 2026',
            'total_litres' => 58.00,
            'milk_rate' => 60.00,
            'subtotal' => 3480.00,
            'additional_products_amount' => 500.00, // Paneer
            'discount_amount' => 100.00,
            'total_amount' => 3880.00,
            'paid_amount' => 2400.00,
            'pending_amount' => 1480.00,
            'status' => 'partial',
            'due_date' => Carbon::now()->addDays(5),
        ]);

        // Prior Month Bill for Rajesh (August 2026 - Paid)
        Bill::create([
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $rajeshCustomer->id,
            'bill_number' => 'INV-202608-101',
            'month_year' => 'August 2026',
            'total_litres' => 62.00,
            'milk_rate' => 60.00,
            'subtotal' => 3720.00,
            'additional_products_amount' => 0.00,
            'discount_amount' => 0.00,
            'total_amount' => 3720.00,
            'paid_amount' => 3720.00,
            'pending_amount' => 0.00,
            'status' => 'paid',
            'due_date' => Carbon::now()->subDays(20),
        ]);

        // Bills for other customers
        foreach (array_slice($allCustomerModels, 1) as $idx => $c) {
            $litres = $c->daily_quantity * 30;
            $amt = $litres * $c->rate_per_litre;
            $status = ($idx % 3 === 0) ? 'paid' : (($idx % 3 === 1) ? 'partial' : 'unpaid');
            $paid = ($status === 'paid') ? $amt : (($status === 'partial') ? round($amt * 0.5) : 0);
            $pending = $amt - $paid;

            Bill::create([
                'dairy_id' => $shreeKrishna->id,
                'customer_id' => $c->id,
                'bill_number' => 'INV-202609-' . (102 + $idx),
                'month_year' => 'September 2026',
                'total_litres' => $litres,
                'milk_rate' => $c->rate_per_litre,
                'subtotal' => $amt,
                'additional_products_amount' => ($idx === 1 ? 360 : 0),
                'discount_amount' => 0,
                'total_amount' => $amt + ($idx === 1 ? 360 : 0),
                'paid_amount' => $paid,
                'pending_amount' => $pending + ($idx === 1 ? 360 : 0),
                'status' => $status,
                'due_date' => Carbon::now()->addDays(7),
            ]);
        }

        // 9. Payments
        Payment::create([
            'transaction_id' => 'MF202609050012',
            'reference_no' => 'UPI/GPay/9827104928',
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $rajeshCustomer->id,
            'bill_id' => $rajeshBill->id,
            'type' => 'bill',
            'amount' => 2400.00,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now()->subDays(3),
            'status' => 'approved',
            'notes' => 'Google Pay payment received from Rajesh Sharma',
        ]);

        Payment::create([
            'transaction_id' => 'MF202609070088',
            'reference_no' => 'CASH/REC/092',
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $allCustomerModels[1]->id,
            'type' => 'bill',
            'amount' => 2000.00,
            'payment_method' => 'cash',
            'payment_date' => Carbon::now()->subDays(1),
            'status' => 'approved',
            'notes' => 'Cash received by delivery boy Suresh Parmar',
        ]);

        Payment::create([
            'transaction_id' => 'MF202609080005',
            'reference_no' => 'UPI/PhonePe/882194',
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $allCustomerModels[2]->id,
            'type' => 'bill',
            'amount' => 3600.00,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now()->subHours(2),
            'status' => 'approved',
            'notes' => 'PhonePe QR scan at shop counter',
        ]);

        // 10. Support Tickets
        SupportTicket::create([
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $rajeshCustomer->id,
            'ticket_number' => 'TCK-2026-081',
            'subject' => 'Need extra 2L Cow Milk this Sunday (Sept 13)',
            'message' => 'Hello Rajesh ji, we have family guests arriving this Sunday morning. Please deliver 4 Litres instead of regular 2 Litres.',
            'status' => 'resolved',
            'reply' => 'Noted Rajesh ji! We have scheduled 4L Cow Milk for Sunday morning Sept 13.',
        ]);

        SupportTicket::create([
            'dairy_id' => $shreeKrishna->id,
            'customer_id' => $allCustomerModels[1]->id,
            'ticket_number' => 'TCK-2026-082',
            'subject' => 'Pause delivery from Sept 15 to Sept 18',
            'message' => 'Going out of town for 4 days. Please pause delivery during this time.',
            'status' => 'open',
            'reply' => null,
        ]);

        // 11. Notifications
        Notification::create([
            'dairy_id' => $shreeKrishna->id,
            'user_id' => $dairyAdmin->id,
            'title' => 'Daily Milk Dispatched',
            'message' => 'Morning shift delivery started by Suresh Parmar (Scheme 54 route).',
            'type' => 'delivery',
            'is_read' => false,
        ]);

        Notification::create([
            'dairy_id' => $shreeKrishna->id,
            'user_id' => $dairyAdmin->id,
            'title' => 'UPI Payment Received ₹2,400',
            'message' => 'Customer Rajesh Sharma paid ₹2,400 via Google Pay.',
            'type' => 'success',
            'is_read' => true,
        ]);

        Notification::create([
            'dairy_id' => $shreeKrishna->id,
            'user_id' => $customerUser->id,
            'title' => 'Milk Delivered Successfully',
            'message' => 'Today\'s 2.0 L Cow Milk delivered at 06:45 AM.',
            'type' => 'delivery',
            'is_read' => false,
        ]);

        Notification::create([
            'dairy_id' => $shreeKrishna->id,
            'user_id' => $customerUser->id,
            'title' => 'Monthly Bill Generated',
            'message' => 'Your September 2026 bill of ₹3,880 is ready. Pending due: ₹1,480.',
            'type' => 'bill',
            'is_read' => false,
        ]);

        Notification::create([
            'dairy_id' => null,
            'user_id' => $superAdmin->id,
            'title' => 'New Dairy Registration Pending',
            'message' => 'Annapurna Dairy (Ujjain) registered for Basic Plan. Payment verification pending.',
            'type' => 'subscription',
            'is_read' => false,
        ]);
    }
}
