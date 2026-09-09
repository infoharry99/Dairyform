<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\DairyAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. PUBLIC MARKETING & ONBOARDING
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/how-it-works', [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// ==========================================
// 2. AUTHENTICATION & DEMO UTILITIES
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// Instant Demo Role Switcher & Database Reset
Route::get('/demo/switch/{role}', [AuthController::class, 'switchRole'])->name('demo.switch');
Route::get('/demo/reset', [AuthController::class, 'resetDemo'])->name('demo.reset');

// ==========================================
// 3. SUPER ADMIN PORTAL
// ==========================================
Route::prefix('super-admin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dairies', [SuperAdminController::class, 'dairies'])->name('dairies');
    Route::post('/dairies/{id}/status/{status}', [SuperAdminController::class, 'toggleDairyStatus'])->name('dairies.status');
    Route::post('/dairies/{id}/plan', [SuperAdminController::class, 'changeDairyPlan'])->name('dairies.change-plan');
    Route::get('/subscriptions', [SuperAdminController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/payments', [SuperAdminController::class, 'payments'])->name('payments');
    Route::post('/payments/{id}/approve', [SuperAdminController::class, 'approvePayment'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [SuperAdminController::class, 'rejectPayment'])->name('payments.reject');
    Route::get('/customers', [SuperAdminController::class, 'customers'])->name('customers');
    Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports');
    Route::get('/notifications', [SuperAdminController::class, 'notifications'])->name('notifications');
    Route::get('/support', [SuperAdminController::class, 'support'])->name('support');
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [SuperAdminController::class, 'saveSettings'])->name('settings.save');
});

// ==========================================
// 4. DAIRY ADMIN PORTAL (TENANT CORE)
// ==========================================
Route::prefix('dairy')->name('dairy.')->group(function () {
    Route::get('/dashboard', [DairyAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [DairyAdminController::class, 'customers'])->name('customers');
    Route::post('/customers', [DairyAdminController::class, 'storeCustomer'])->name('customers.store');
    Route::post('/customers/{id}/toggle-status', [DairyAdminController::class, 'toggleCustomerStatus'])->name('customers.toggle-status');
    Route::get('/customers/{id}/profile', [DairyAdminController::class, 'customerProfile'])->name('customers.profile');
    Route::get('/milk', [DairyAdminController::class, 'milk'])->name('milk');
    Route::post('/milk/{id}', [DairyAdminController::class, 'updateMilkRecord'])->name('milk.update');
    Route::get('/delivery', [DairyAdminController::class, 'delivery'])->name('delivery');
    Route::get('/billing', [DairyAdminController::class, 'billing'])->name('billing');
    Route::post('/billing/generate', [DairyAdminController::class, 'generateBill'])->name('billing.generate');
    Route::get('/payments', [DairyAdminController::class, 'payments'])->name('payments');
    Route::post('/payments/store', [DairyAdminController::class, 'storePayment'])->name('payments.store');
    Route::get('/products', [DairyAdminController::class, 'products'])->name('products');
    Route::post('/products', [DairyAdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/staff', [DairyAdminController::class, 'staff'])->name('staff');
    Route::get('/reports', [DairyAdminController::class, 'reports'])->name('reports');
    Route::get('/notifications', [DairyAdminController::class, 'notifications'])->name('notifications');
    Route::get('/settings', [DairyAdminController::class, 'settings'])->name('settings');
});

// ==========================================
// 5. CUSTOMER PORTAL (MOBILE-FIRST APP)
// ==========================================
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/milk', [CustomerPortalController::class, 'milk'])->name('milk');
    Route::get('/bills', [CustomerPortalController::class, 'bills'])->name('bills');
    Route::get('/payments', [CustomerPortalController::class, 'payments'])->name('payments');
    Route::post('/pay', [CustomerPortalController::class, 'processPayment'])->name('pay');
    Route::get('/schedule', [CustomerPortalController::class, 'schedule'])->name('schedule');
    Route::post('/schedule', [CustomerPortalController::class, 'requestScheduleChange'])->name('schedule.request');
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
    Route::get('/support', [CustomerPortalController::class, 'support'])->name('support');
    Route::post('/support', [CustomerPortalController::class, 'storeSupportTicket'])->name('support.store');
});

// ==========================================
// 6. CUSTOMER MOBILE APP REST API
// ==========================================
Route::prefix('api/customer')->name('api.customer.')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\CustomerApiController::class, 'login']);
    Route::get('/dashboard/{id?}', [\App\Http\Controllers\Api\CustomerApiController::class, 'dashboard']);
    Route::get('/milk/{id?}', [\App\Http\Controllers\Api\CustomerApiController::class, 'milkRecords']);
    Route::get('/bills/{id?}', [\App\Http\Controllers\Api\CustomerApiController::class, 'bills']);
    Route::post('/pay', [\App\Http\Controllers\Api\CustomerApiController::class, 'pay']);
    Route::post('/schedule', [\App\Http\Controllers\Api\CustomerApiController::class, 'requestSchedule']);
    Route::get('/support/{id?}', [\App\Http\Controllers\Api\CustomerApiController::class, 'supportTickets']);
    Route::post('/support', [\App\Http\Controllers\Api\CustomerApiController::class, 'createTicket']);
});
