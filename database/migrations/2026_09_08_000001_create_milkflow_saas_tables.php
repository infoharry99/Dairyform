<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Dairies (Tenants)
        Schema::create('dairies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('owner_name');
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->text('address');
            $table->enum('status', ['active', 'pending', 'expired', 'suspended'])->default('active');
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        // 2. Update users table with role & tenant linkage
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dairy_id')->nullable()->constrained('dairies')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->enum('role', ['super_admin', 'dairy_admin', 'customer', 'staff'])->default('customer');
            $table->string('status')->default('active');
        });

        // 3. Subscription Plans
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->integer('price_monthly');
            $table->integer('price_half_yearly');
            $table->integer('price_yearly');
            $table->integer('customer_limit');
            $table->integer('staff_limit');
            $table->text('features'); // JSON stored as text
            $table->boolean('is_popular')->default(false);
            $table->timestamps();
        });

        // 4. Subscriptions
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();
            $table->enum('billing_cycle', ['monthly', 'half_yearly', 'yearly'])->default('monthly');
            $table->decimal('amount', 10, 2);
            $table->date('starts_at');
            $table->date('expires_at');
            $table->enum('status', ['active', 'expiring_soon', 'expired', 'pending', 'suspended'])->default('active');
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
        });

        // 5. Customers
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_code');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('area'); // Vijay Nagar, Scheme 54, Palasia, Rau
            $table->decimal('daily_quantity', 6, 2)->default(1.0);
            $table->enum('milk_type', ['cow', 'buffalo', 'mixed'])->default('cow');
            $table->enum('delivery_time', ['morning', 'evening', 'both'])->default('morning');
            $table->decimal('rate_per_litre', 8, 2)->default(60.0);
            $table->enum('status', ['active', 'paused'])->default('active');
            $table->date('start_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 6. Milk Records
        Schema::create('milk_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('date');
            $table->enum('shift', ['morning', 'evening'])->default('morning');
            $table->decimal('quantity', 6, 2);
            $table->enum('milk_type', ['cow', 'buffalo', 'mixed'])->default('cow');
            $table->decimal('rate', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['delivered', 'pending', 'skipped', 'paused'])->default('pending');
            $table->string('recorded_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 7. Products (Value added dairy products)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->string('name');
            $table->string('category'); // milk, curd, paneer, ghee, butter, buttermilk
            $table->decimal('price', 10, 2);
            $table->string('unit'); // L, kg, packet, 500g
            $table->integer('stock')->default(0);
            $table->enum('status', ['in_stock', 'low_stock', 'out_of_stock'])->default('in_stock');
            $table->timestamps();
        });

        // 8. Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('bill_number')->unique();
            $table->string('month_year'); // e.g. "September 2026"
            $table->decimal('total_litres', 8, 2);
            $table->decimal('milk_rate', 8, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('additional_products_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('pending_amount', 10, 2)->default(0);
            $table->enum('status', ['paid', 'partial', 'unpaid'])->default('unpaid');
            $table->date('due_date');
            $table->timestamps();
        });

        // 9. Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('reference_no')->nullable();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('bill_id')->nullable()->constrained('bills')->nullOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();
            $table->enum('type', ['bill', 'subscription'])->default('bill');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['upi', 'cash', 'bank_transfer', 'online', 'card'])->default('upi');
            $table->dateTime('payment_date');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('approved');
            $table->string('proof_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 10. Staff
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->enum('role', ['manager', 'delivery_boy', 'accountant'])->default('delivery_boy');
            $table->string('assigned_area')->nullable();
            $table->text('permissions')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // 11. Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->nullable()->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning, bill, delivery, subscription
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // 12. Support Tickets
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_id')->constrained('dairies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('ticket_number');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->text('reply')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('products');
        Schema::dropIfExists('milk_records');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dairy_id']);
            $table->dropColumn(['dairy_id', 'phone', 'role', 'status']);
        });
        Schema::dropIfExists('dairies');
    }
};
