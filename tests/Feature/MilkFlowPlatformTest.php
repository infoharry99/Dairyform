<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilkFlowPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_public_pages_load_successfully(): void
    {
        $publicRoutes = ['/', '/features', '/how-it-works', '/pricing', '/about', '/contact', '/login', '/register'];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_demo_role_switcher_redirects(): void
    {
        $response = $this->get('/demo/switch/super_admin');
        $response->assertRedirect('/super-admin/dashboard');

        $response = $this->get('/demo/switch/dairy_admin');
        $response->assertRedirect('/dairy/dashboard');

        $response = $this->get('/demo/switch/customer');
        $response->assertRedirect('/customer/dashboard');
    }

    public function test_super_admin_portal_routes(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $routes = [
            '/super-admin/dashboard',
            '/super-admin/dairies',
            '/super-admin/subscriptions',
            '/super-admin/payments',
            '/super-admin/customers',
            '/super-admin/reports',
            '/super-admin/notifications',
            '/super-admin/support',
            '/super-admin/settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_dairy_admin_portal_routes(): void
    {
        $dairyAdmin = User::where('role', 'dairy_admin')->first();
        $this->actingAs($dairyAdmin);

        $routes = [
            '/dairy/dashboard',
            '/dairy/customers',
            '/dairy/milk',
            '/dairy/delivery',
            '/dairy/billing',
            '/dairy/payments',
            '/dairy/products',
            '/dairy/staff',
            '/dairy/reports',
            '/dairy/notifications',
            '/dairy/settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_customer_portal_routes(): void
    {
        $customerUser = User::where('role', 'customer')->first();
        $this->actingAs($customerUser);

        $routes = [
            '/customer/dashboard',
            '/customer/milk',
            '/customer/bills',
            '/customer/payments',
            '/customer/schedule',
            '/customer/profile',
            '/customer/support',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_customer_payment_simulation_flow(): void
    {
        $customerUser = User::where('role', 'customer')->first();
        $this->actingAs($customerUser);

        $response = $this->post('/customer/pay', [
            'amount' => 1480,
            'payment_method' => 'upi',
        ]);

        $response->assertSessionHas('payment_success');
        $response->assertRedirect();
    }
}
