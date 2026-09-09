# 🏪 MilkFlow Dairy Admin Mobile App (Flutter)

Modern, high-efficiency Flutter mobile application built for **Dairy Shop Owners and Delivery Managers** on the **MilkFlow Dairy Management SaaS Platform**.

This mobile app empowers dairy owners to manage daily morning and evening milk deliveries on the go, add route customers, record offline cash and UPI payments, review vacation pause and extra milk requests, generate monthly bills, and maintain product inventory and prices.

---

## 📱 Features & Capabilities

1. **Owner Authentication & 1-Click Demo Login:**
   - Preloaded with credentials for **Ramesh Patel (`Shree Krishna Dairy Farm`)**.
   - Instant 1-click demo sign-in for seamless client showcases.

2. **Smart Operational Dashboard:**
   - Shift delivery tracker (Morning 240L completed, Evening 172L in progress).
   - Financial KPIs: Today's Collection (₹28,450), Customer Outstanding Dues (₹48,200).
   - Active customer accounts count (312 active out of 324 total).
   - Quick action shortcuts for fast daily entries.

3. **High-Speed Daily Milk Entry / Delivery Logger:**
   - Instant Morning ☀️ vs Evening 🌙 shift toggle.
   - Fast `+` / `-` quantity steppers (by 0.5L increments).
   - One-tap status toggles: **[Delivered]**, **[Absent]**, **[Extra]**.
   - **"Mark All Delivered"** batch action to complete a shift in 1 tap.
   - Real-time litres counter and bill calculation per delivery.

4. **Customer Route Management:**
   - Full customer directory with instant search by name or code (`CUST-101`).
   - Route area filters: Vijay Nagar, Palasia, Scheme 54, Rau.
   - Direct Call and WhatsApp chat buttons for each customer.
   - 1-tap subscription pause/resume.
   - **Add New Customer** bottom sheet form (Name, mobile, route area, quota, milk type, rate).

5. **Billing & Payment Collection:**
   - **1-Click Generate Monthly Invoices** for all active route customers.
   - **Record Offline Payment** modal: Cash, UPI QR, Bank Cheque, with instant balance settlement.
   - Monthly invoice ledger with status badges (`PAID`, `PARTIAL`, `PENDING`).

6. **Customer Action Requests (Help Desk):**
   - Review incoming vacation pause requests and extra milk bookings.
   - 1-tap **Approve** (marks resolved and updates schedule) or **Reject** with custom customer message.

7. **Product Rates & Inventory Catalog:**
   - Buffalo Milk, Cow Milk, Traditional Desi Ghee (Bilona), Fresh Paneer, Dahi, Butter.
   - Inline price and stock updater.

8. **Dairy Profile & SaaS Subscription:**
   - View active MilkFlow SaaS plan (`Professional Plan - Active`).
   - Dairy helpline, route zones, and assigned delivery fleet overview.

---

## 🛠 Project Structure

```
dairy_admin_app/
├── pubspec.yaml                 # Dependencies (http, intl, google_fonts, etc.)
├── README.md                    # Setup and execution guide
├── android/
│   └── app/src/main/
│       └── AndroidManifest.xml  # Cleartext HTTP & network permissions
└── lib/
    ├── main.dart                # App entry point
    ├── constants/
    │   ├── app_colors.dart      # Emerald & Slate palette
    │   └── app_theme.dart       # Material 3 typography and cards
    ├── models/
    │   ├── dairy_model.dart     # Dairy profile & subscription
    │   ├── customer_summary_model.dart # Customer roster & dues
    │   ├── milk_entry_model.dart # Shift delivery row
    │   ├── admin_bill_model.dart # Monthly customer invoices
    │   ├── customer_request_model.dart # Pause & extra milk requests
    │   └── dairy_product_model.dart # Product catalog & rates
    ├── services/
    │   └── dairy_api_service.dart # Online REST client + offline demo fallback
    ├── widgets/
    │   ├── kpi_card.dart        # KPI metric cards
    │   ├── status_pill.dart     # Status badges
    │   └── primary_button.dart  # Action buttons with loading state
    └── screens/
        ├── splash_screen.dart   # Brand splash screen
        ├── login_screen.dart    # Login with 1-click demo button
        ├── admin_main_navigation_screen.dart # 5-tab bottom navigation
        ├── dashboard_screen.dart# Shift overview & financial KPIs
        ├── daily_milk_entry_screen.dart # Fast shift milk entry
        ├── customer_management_screen.dart # Customer roster & add modal
        ├── billing_payments_screen.dart # Payment recording & bill generation
        ├── customer_requests_screen.dart # Pause/Extra requests approvals
        ├── products_screen.dart # Product catalog & rate editor
        └── dairy_settings_screen.dart # Subscription & store settings
```

---

## 🚀 How to Run the App

### Prerequisites
1. [Flutter SDK](https://docs.flutter.dev/get-started/install) installed (version 3.0.0 or higher).
2. Android Studio, VS Code, or Xcode.

### Step 1: Navigate to the `dairy_admin_app` directory
```bash
cd "d:/Dairy Project/dairy_admin_app"
```

### Step 2: Install dependencies
```bash
flutter pub get
```

### Step 3: Run the App
#### On Chrome / Web:
```bash
flutter run -d chrome
```

#### On Android Emulator / Connected Device:
```bash
flutter run
```

---

## 🌐 Connecting to Laravel Backend

The mobile app includes a smart `DairyApiService` (`lib/services/dairy_api_service.dart`):

1. **Automatic Offline / Demo Mode:**
   - If the backend is not running or device is offline, the app automatically switches to demo mode with full interactive state updates (pre-loaded with Shree Krishna Dairy Farm and realistic customer records).

2. **Online Mode (Connecting to Laravel API):**
   - **Android Emulator:** Uses `http://10.0.2.2:8000/api/dairy` (pre-configured).
   - **Web / Windows:** Uses `http://localhost:8000/api/dairy` (pre-configured).
   - **Physical Device:** Update the `baseUrl` in `lib/services/dairy_api_service.dart` with your machine's Wi-Fi / LAN IP (e.g. `http://192.168.1.15:8000/api/dairy`).

Ensure your Laravel backend is running:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 🔑 Demo Credentials

- **Email:** `dairy@milkflow.demo`
- **Phone:** `9826012345`
- **Password:** `password`
- **Dairy Name:** Shree Krishna Dairy Farm (Proprietor: Ramesh Patel)
- Or tap the **"1-Click Demo Sign In"** button on the login screen.
