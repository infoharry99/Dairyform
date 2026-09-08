# Dairyform

# MilkFlow - Smart Dairy Management SaaS Platform

MilkFlow is a modern, production-quality, multi-tenant Dairy Management SaaS Platform built with **Laravel 12** and **Tailwind CSS**. Designed for local village and urban dairy shops, farm cooperatives, and milk delivery businesses.

## Features
- **Public SaaS Marketing Website**: Hero with dashboard preview, trusted statistics, pricing with billing cycle switcher, and onboarding wizard.
- **Super Admin Portal**: Tenant oversight, 1,248 dairies, revenue analytics, subscription management, and payment verification desk.
- **Dairy Admin Portal (Tenant Core)**: Morning & evening milk tracking, customer management, route delivery dispatch, automated billing with WhatsApp PDF invoices, products catalog, and staff management.
- **Customer Portal**: Mobile-first self-service app, delivery tracking, billing statements, simulated instant UPI payments, and vacation pause requests.
- **Demo Showcase Navigator**: 1-click role switcher, 5-minute interactive guided tour, and instant demo database reset.

## Quick Start
1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Start local server:
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000`

## Demo Accounts
- **Super Admin**: `admin@milkflow.demo` / `password`
- **Dairy Admin**: `dairy@milkflow.demo` / `password`
- **Customer**: `customer@milkflow.demo` / `password`
