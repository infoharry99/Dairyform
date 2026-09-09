# 🥛 MilkFlow Customer Mobile App (Flutter)

Modern, production-grade Flutter mobile application for customers of the **MilkFlow Dairy Management SaaS Platform**.

This mobile app empowers customers to track their daily morning and evening milk deliveries, review detailed monthly bills, make simulated instant UPI payments with receipt generation, request vacation pause or extra milk, and directly contact or chat with their local dairy provider.

---

## 📱 App Highlights & Features

1. **Branded Splash & Smooth Onboarding:**
   - Emerald & dairy farm theme (`#15803D`).
   - Clean sign-in screen with a **1-Click Demo Login** button preconfigured for demo customer **Rajesh Sharma (`CUST-101`)**.

2. **Smart Live Dashboard:**
   - Today's morning delivery status (`2.0 Litres Delivered at 06:45 AM` by delivery boy `Suresh Parmar`).
   - Active monthly summary (Total litres received, agreed rate per litre: ₹65/L, pending dues: ₹1,480).
   - Quick action shortcuts: Pause Supply, Extra Milk, Call Dairy.
   - 7-day recent delivery log with shift badges.

3. **Milk Delivery History (Monthly Log):**
   - Detailed calendar list of every delivery.
   - Filter chips: All, Delivered, Paused.
   - Visual shift indicators (Morning ☀️ / Evening 🌙), quantity, rate, and delivery status.

4. **Invoices & Instant UPI Payment:**
   - Complete history of monthly invoices with status badges (`PAID`, `PARTIAL`, `PENDING`).
   - Itemized invoice breakdown: Milk volume × rate, additional dairy items (Desi Ghee, Paneer), and prompt payment discounts.
   - Integrated simulated UPI Payment Gateway (Google Pay, PhonePe, Paytm, BHIM).
   - Instant receipt generator (`MF202609080001`) with transaction timestamp and live balance update to `PAID`.

5. **Vacation Pause & Extra Milk Requests:**
   - **Vacation Pause:** Select start and end dates with reason to pause daily deliveries during holidays.
   - **Extra Milk Request:** Request additional litres (+1L, +2L, +3L, +5L) for specific dates and shifts.
   - Automatically synchronizes with Dairy Admin backend support tickets.

6. **Support & Dairy Help Desk:**
   - Direct 1-tap call and WhatsApp chat buttons to dairy shop owner (`+91 98260 12345`).
   - Raise support queries (Delivery timing, milk quality, billing, extra dairy products).
   - View dairy replies and resolution history.

7. **Customer Profile & Subscription:**
   - View assigned dairy shop info (`Shree Krishna Dairy Farm`), route zone, daily milk quota, milk variety (Fresh Buffalo Milk A2), and agreed price per litre.

---

## 🛠 Project Structure

```
customer_app/
├── pubspec.yaml                 # Dependencies and asset declarations
├── README.md                    # Setup and execution guide
├── android/
│   └── app/src/main/
│       └── AndroidManifest.xml  # Cleartext HTTP & network permissions
└── lib/
    ├── main.dart                # App entry point and theme bootstrapping
    ├── constants/
    │   ├── app_colors.dart      # Emerald, sky blue, amber, slate palette
    │   └── app_theme.dart       # Material 3 theme and typography
    ├── models/
    │   ├── customer_model.dart  # Customer details model & mock
    │   ├── milk_record_model.dart # Daily shift deliveries model
    │   ├── bill_model.dart      # Monthly invoice model
    │   └── support_ticket_model.dart # Ticket & queries model
    ├── services/
    │   └── api_service.dart     # REST API client + offline demo fallback
    ├── widgets/
    │   ├── metric_card.dart     # Reusable dashboard metric card
    │   ├── shift_badge.dart     # Shift & delivery status pills
    │   └── custom_button.dart   # Primary/outlined action buttons
    └── screens/
        ├── splash_screen.dart   # Animated brand splash screen
        ├── login_screen.dart    # Auth screen with 1-click demo login
        ├── main_navigation_screen.dart # 5-tab bottom navigation
        ├── dashboard_screen.dart# Today's delivery & month summary
        ├── milk_history_screen.dart # Delivery logs & filters
        ├── bills_screen.dart    # Itemized bills & breakdown sheet
        ├── payment_screen.dart  # Instant UPI payment & receipt
        ├── schedule_screen.dart # Vacation pause & extra milk tabs
        ├── support_screen.dart  # Ticket manager & dairy contacts
        └── profile_screen.dart  # Subscription quota & dairy info
```

---

## 🚀 How to Run the App

### Prerequisites
1. Install [Flutter SDK](https://docs.flutter.dev/get-started/install) (version 3.0.0 or higher).
2. Ensure Android Studio, VS Code, or Xcode is installed with Flutter plugins.

### Step 1: Navigate to the `customer_app` directory
```bash
cd "d:/Dairy Project/customer_app"
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

#### On Android Emulator:
```bash
flutter run
```

#### On Physical Android Device:
Connect your Android phone via USB with USB debugging enabled, then run:
```bash
flutter run
```

---

## 🌐 Connecting to Laravel Backend

The mobile app includes a smart `ApiService` (`lib/services/api_service.dart`) with built-in dual mode:

1. **Automatic Offline / Demo Mode:**
   - If the Laravel server is not running or network is unavailable, the app automatically switches to demo mode with full interactive functionality (mocking Rajesh Sharma `CUST-101` data, payments, and schedules).

2. **Online Mode (Connecting to Laravel API):**
   - **Android Emulator:** Uses `http://10.0.2.2:8000/api/customer` (pre-configured).
   - **Web / Windows:** Uses `http://localhost:8000/api/customer` (pre-configured).
   - **Physical Device:** Update the `baseUrl` in `lib/services/api_service.dart` with your machine's Wi-Fi / LAN IP (e.g. `http://192.168.1.15:8000/api/customer`).

Ensure your Laravel backend is running:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 🔑 Demo Credentials

- **Mobile:** `9893011223` (or `customer@milkflow.demo`)
- **Password:** `password`
- **Customer Code:** `CUST-101` (Rajesh Sharma)
- Or tap the **"1-Click Demo Sign In"** button on the login screen.
