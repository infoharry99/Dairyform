-- ==========================================================
-- MilkFlow Dairy Management SaaS Platform - Database Dump
-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB, phpMyAdmin
-- Generated on: 2026-09-08
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- Table structure for `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_08_000001_create_milkflow_saas_tables', 2);

-- Table structure for `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `sessions`
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('j7zcBes23A6f9GVBUxqrAOK01NaGepnQRfRh72Tc', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVXhvTUhJN0xWdjFlQ2RkM0l4U0VESzlabTBQRnJzUDU2NXRrd1IzdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZW1vL3N3aXRjaC9kYWlyeV9hZG1pbiI7czo1OiJyb3V0ZSI7czoxMToiZGVtby5zd2l0Y2giO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6Nzoic3VjY2VzcyI7czo0NjoiU3dpdGNoZWQgc2Vzc2lvbiB0byBEYWlyeSBBZG1pbiAoUmFqZXNoIFBhdGVsKSI7fQ==', 1788862996),
('xa6qfVyx0UJHjjKa6BNYKVMgXHTdh31EQ7oEYiC1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkRsVjgwZnhGTDUxQVVaTkVrdllKeWF2aXRlbVh3Z3JDaVNnZHJacCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO319', 1788865643),
('RbQ9Biyhb9GPoRvzPCUp5zwkwpGv0PZIz5LDH9YD', NULL, '127.0.0.1', 'Go-http-client/1.1', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicU1tbUROZGRMM1BVMnNFM0tKWVBwcnMyUTN4NmpKOUVWdlNSSnEyVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788865706),
('oLXwOYGdbjo1g1AF2IxjYaht0ZNfjxoAnjVgPeDd', NULL, '127.0.0.1', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZThFUnJrdmRzRjAyU0hlcDNKNnNTVUNaZWxQeUNTSDIwMHdFMU9JMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1788865706);

-- Table structure for `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `jobs`
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `job_batches`
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `failed_jobs`
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `dairies`
DROP TABLE IF EXISTS `dairies`;
CREATE TABLE `dairies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` enum('active','pending','expired','suspended') NOT NULL DEFAULT 'active',
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dairies_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `dairies`
INSERT INTO `dairies` (`id`, `name`, `slug`, `owner_name`, `email`, `phone`, `city`, `address`, `status`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Shree Krishna Dairy', 'shree-krishna-dairy', 'Rajesh Patel', 'dairy@milkflow.demo', '+91 98260 12345', 'Indore', 'Plot 42, Annapurna Road, Near Mandir, Indore, MP 452009', 'active', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 'Fresh Milk Dairy', 'fresh-milk-dairy', 'Amit Verma', 'amit@freshmilk.demo', '+91 98260 23456', 'Bhopal', '12 Arera Colony, Near Bittan Market, Bhopal, MP', 'active', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(3, 'Annapurna Dairy', 'annapurna-dairy', 'Ramesh Joshi', 'ramesh@annapurna.demo', '+91 98260 34567', 'Ujjain', '78 Freeganj Main Road, Ujjain, MP', 'pending', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(4, 'Radha Dairy', 'radha-dairy', 'Suresh Sharma', 'suresh@radhadairy.demo', '+91 98260 45678', 'Dewas', 'Station Road, Dewas, MP', 'active', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(5, 'Maa Narmada Dairy', 'maa-narmada-dairy', 'Vikram Singh', 'vikram@maanarmada.demo', '+91 98260 56789', 'Rau', 'AB Road, Near Rau Circle, Indore, MP', 'expired', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27');

-- Table structure for `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','dairy_admin','customer','staff') NOT NULL DEFAULT 'customer',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_dairy_id_foreign` (`dairy_id`),
  CONSTRAINT `users_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `dairy_id`, `phone`, `role`, `status`) VALUES
(1, 'Admin', 'admin@milkflow.demo', NULL, '$2y$12$l7KtQeZugELinpXlCwKFaOg5sXJqFZJruEH9CHfKXA.eEI0Df7gNO', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27', NULL, '+91 98260 00001', 'super_admin', 'active'),
(2, 'Rajesh Patel', 'dairy@milkflow.demo', NULL, '$2y$12$.XqRwhc81EqL6O5a3hFdMei4uLNSMe7khqyLcRNn.UthbVscVwlm6', NULL, '2026-09-08 09:41:27', '2026-09-08 09:41:27', 1, '+91 98260 12345', 'dairy_admin', 'active'),
(3, 'Rajesh Sharma', 'customer@milkflow.demo', NULL, '$2y$12$8FBKwVmFs3XKWW1crzBJL.gk./ycXGiS0rGwcixZHEMlKDzodbtKu', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28', 1, '+91 98930 11223', 'customer', 'active');

-- Table structure for `subscription_plans`
DROP TABLE IF EXISTS `subscription_plans`;
CREATE TABLE `subscription_plans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `price_monthly` int(11) NOT NULL,
  `price_half_yearly` int(11) NOT NULL,
  `price_yearly` int(11) NOT NULL,
  `customer_limit` int(11) NOT NULL,
  `staff_limit` int(11) NOT NULL,
  `features` text NOT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_plans_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `subscription_plans`
INSERT INTO `subscription_plans` (`id`, `name`, `slug`, `tagline`, `price_monthly`, `price_half_yearly`, `price_yearly`, `customer_limit`, `staff_limit`, `features`, `is_popular`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', 'Essential tools for small village milk centers', 499, 2699, 4999, 100, 2, '[\"Up to 100 Customers\",\"Daily Milk Quantity Tracking\",\"Basic Monthly Billing & Invoices\",\"Manual Payment Tracking (Cash)\",\"Standard Mobile Responsive View\",\"Community Email Support\"]', 0, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 'Standard', 'standard', 'The complete operating system for growing dairy shops', 999, 5399, 9999, 500, 6, '[\"Up to 500 Customers\",\"Morning & Evening Shift Tracking\",\"Automated WhatsApp Bill Alerts\",\"Online UPI & QR Code Payments\",\"Customer Self-Service Web App\",\"Additional Dairy Products Catalog\",\"Delivery Boy Route Management\",\"Priority Phone & WhatsApp Support\"]', 1, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(3, 'Premium', 'premium', 'Enterprise automation for large milk suppliers & chains', 1999, 10799, 19999, 2000, 20, '[\"Unlimited Customers\",\"Multi-Route GPS Delivery Tracking\",\"Automated Payment Reconciliation\",\"Fat & SNF Milk Rate Calculator\",\"Complete Inventory & Expiry Tracking\",\"Accountant & Manager Multi-Staff Roles\",\"Automated PDF & Excel Reporting\",\"Dedicated Account Manager (24\\/7)\"]', 0, '2026-09-08 09:41:27', '2026-09-08 09:41:27');

-- Table structure for `subscriptions`
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `billing_cycle` enum('monthly','half_yearly','yearly') NOT NULL DEFAULT 'monthly',
  `amount` decimal(10,2) NOT NULL,
  `starts_at` date NOT NULL,
  `expires_at` date NOT NULL,
  `status` enum('active','expiring_soon','expired','pending','suspended') NOT NULL DEFAULT 'active',
  `auto_renew` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_dairy_id_foreign` (`dairy_id`),
  KEY `subscriptions_plan_id_foreign` (`plan_id`),
  CONSTRAINT `subscriptions_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `subscriptions`
INSERT INTO `subscriptions` (`id`, `dairy_id`, `plan_id`, `billing_cycle`, `amount`, `starts_at`, `expires_at`, `status`, `auto_renew`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'yearly', 9999, '2026-07-08 09:41:27', '2027-07-08 09:41:27', 'active', 1, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 2, 3, 'yearly', 19999, '2026-08-08 09:41:27', '2027-08-08 09:41:27', 'active', 1, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(3, 3, 1, 'monthly', 499, '2026-09-08 09:41:27', '2026-10-08 09:41:27', 'pending', 0, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(4, 4, 2, 'monthly', 999, '2026-08-13 09:41:27', '2026-09-12 09:41:27', 'expiring_soon', 1, '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(5, 5, 1, 'monthly', 499, '2026-07-08 09:41:27', '2026-09-03 09:41:27', 'expired', 0, '2026-09-08 09:41:27', '2026-09-08 09:41:27');

-- Table structure for `customers`
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `area` varchar(255) NOT NULL,
  `daily_quantity` decimal(6,2) NOT NULL DEFAULT 1.00,
  `milk_type` enum('cow','buffalo','mixed') NOT NULL DEFAULT 'cow',
  `delivery_time` enum('morning','evening','both') NOT NULL DEFAULT 'morning',
  `rate_per_litre` decimal(8,2) NOT NULL DEFAULT 60.00,
  `status` enum('active','paused') NOT NULL DEFAULT 'active',
  `start_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_dairy_id_foreign` (`dairy_id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `customers`
INSERT INTO `customers` (`id`, `dairy_id`, `user_id`, `customer_code`, `name`, `phone`, `email`, `address`, `area`, `daily_quantity`, `milk_type`, `delivery_time`, `rate_per_litre`, `status`, `start_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'CUST-101', 'Rajesh Sharma', '+91 98930 11223', 'customer@milkflow.demo', 'Flat 302, Royal Palms, Scheme 54', 'Scheme 54', 2, 'cow', 'morning', 60, 'active', '2026-03-08 09:41:28', 'Ring bell twice and leave can in door holder.', '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(2, 1, NULL, 'CUST-102', 'Priya Verma', '+91 98930 22334', 'priya.v@example.com', 'B-14 Silver Springs, Vijay Nagar', 'Vijay Nagar', 1.5, 'buffalo', 'morning', 72, 'active', '2026-08-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(3, 1, NULL, 'CUST-103', 'Alok Nath', '+91 98930 33445', 'alok.nath@example.com', '22 Anand Bazaar, Palasia', 'Palasia', 3, 'cow', 'both', 60, 'active', '2026-04-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(4, 1, NULL, 'CUST-104', 'Meena Joshi', '+91 98930 44556', 'meena.j@example.com', 'House 55, Green Valley, Rau', 'Rau', 2, 'buffalo', 'morning', 72, 'active', '2025-10-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(5, 1, NULL, 'CUST-105', 'Deepak Tiwari', '+91 98930 55667', 'deepak.t@example.com', '104 Galaxy Apts, Scheme 54', 'Scheme 54', 1, 'cow', 'evening', 60, 'active', '2026-03-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(6, 1, NULL, 'CUST-106', 'Sunita Dubey', '+91 98930 66778', 'sunita.d@example.com', 'C-8 Maple Woods, Vijay Nagar', 'Vijay Nagar', 2.5, 'mixed', 'morning', 65, 'paused', '2026-08-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(7, 1, NULL, 'CUST-107', 'Sanjay Rathore', '+91 98930 77889', 'sanjay.r@example.com', '401 Sapphire Heights, Palasia', 'Palasia', 2, 'cow', 'morning', 60, 'active', '2025-10-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(8, 1, NULL, 'CUST-108', 'Anita Agarwal', '+91 98930 88990', 'anita.a@example.com', 'Villa 12, Classic Colony, Scheme 54', 'Scheme 54', 1.5, 'buffalo', 'morning', 72, 'active', '2026-03-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(9, 1, NULL, 'CUST-109', 'Rahul Chauhan', '+91 98930 99001', 'rahul.c@example.com', 'Sector A, Vijay Nagar', 'Vijay Nagar', 2, 'cow', 'evening', 60, 'active', '2025-09-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(10, 1, NULL, 'CUST-110', 'Kavita Malviya', '+91 98930 12999', 'kavita.m@example.com', '31 Mahadev Colony, Rau', 'Rau', 1, 'cow', 'morning', 60, 'active', '2026-08-08 09:41:28', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28');

-- Table structure for `milk_records`
DROP TABLE IF EXISTS `milk_records`;
CREATE TABLE `milk_records` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening') NOT NULL DEFAULT 'morning',
  `quantity` decimal(6,2) NOT NULL,
  `milk_type` enum('cow','buffalo','mixed') NOT NULL DEFAULT 'cow',
  `rate` decimal(8,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('delivered','pending','skipped','paused') NOT NULL DEFAULT 'pending',
  `recorded_by` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milk_records_dairy_id_foreign` (`dairy_id`),
  KEY `milk_records_customer_id_foreign` (`customer_id`),
  CONSTRAINT `milk_records_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `milk_records_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `milk_records`
INSERT INTO `milk_records` (`id`, `dairy_id`, `customer_id`, `date`, `shift`, `quantity`, `milk_type`, `rate`, `amount`, `status`, `recorded_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-09-08 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(2, 1, 1, '2026-09-07 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(3, 1, 1, '2026-09-06 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(4, 1, 1, '2026-09-05 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(5, 1, 1, '2026-09-04 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(6, 1, 1, '2026-09-03 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(7, 1, 1, '2026-09-02 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(8, 1, 1, '2026-09-01 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(9, 1, 2, '2026-09-08 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(10, 1, 2, '2026-09-07 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(11, 1, 2, '2026-09-06 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(12, 1, 2, '2026-09-05 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(13, 1, 2, '2026-09-04 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(14, 1, 2, '2026-09-03 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(15, 1, 2, '2026-09-02 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(16, 1, 2, '2026-09-01 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(17, 1, 3, '2026-09-08 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(18, 1, 3, '2026-09-08 00:00:00', 'evening', 3, 'cow', 60, 180, 'pending', 'Kamlesh Yadav', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(19, 1, 3, '2026-09-07 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(20, 1, 3, '2026-09-06 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(21, 1, 3, '2026-09-05 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(22, 1, 3, '2026-09-04 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(23, 1, 3, '2026-09-03 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(24, 1, 3, '2026-09-02 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(25, 1, 3, '2026-09-01 00:00:00', 'morning', 3, 'cow', 60, 180, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(26, 1, 4, '2026-09-08 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(27, 1, 4, '2026-09-07 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(28, 1, 4, '2026-09-06 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(29, 1, 4, '2026-09-05 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(30, 1, 4, '2026-09-04 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(31, 1, 4, '2026-09-03 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(32, 1, 4, '2026-09-02 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(33, 1, 4, '2026-09-01 00:00:00', 'morning', 2, 'buffalo', 72, 144, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(34, 1, 5, '2026-09-08 00:00:00', 'morning', 1, 'cow', 60, 60, 'pending', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(35, 1, 5, '2026-09-08 00:00:00', 'evening', 1, 'cow', 60, 60, 'pending', 'Kamlesh Yadav', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(36, 1, 5, '2026-09-07 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(37, 1, 5, '2026-09-06 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(38, 1, 5, '2026-09-05 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(39, 1, 5, '2026-09-04 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(40, 1, 5, '2026-09-03 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(41, 1, 5, '2026-09-02 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(42, 1, 5, '2026-09-01 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(43, 1, 6, '2026-09-08 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'skipped', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(44, 1, 6, '2026-09-07 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(45, 1, 6, '2026-09-06 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(46, 1, 6, '2026-09-05 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(47, 1, 6, '2026-09-04 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(48, 1, 6, '2026-09-03 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(49, 1, 6, '2026-09-02 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(50, 1, 6, '2026-09-01 00:00:00', 'morning', 2.5, 'mixed', 65, 162.5, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(51, 1, 7, '2026-09-08 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(52, 1, 7, '2026-09-07 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(53, 1, 7, '2026-09-06 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(54, 1, 7, '2026-09-05 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(55, 1, 7, '2026-09-04 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(56, 1, 7, '2026-09-03 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(57, 1, 7, '2026-09-02 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(58, 1, 7, '2026-09-01 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(59, 1, 8, '2026-09-08 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(60, 1, 8, '2026-09-07 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(61, 1, 8, '2026-09-06 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(62, 1, 8, '2026-09-05 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(63, 1, 8, '2026-09-04 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(64, 1, 8, '2026-09-03 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(65, 1, 8, '2026-09-02 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(66, 1, 8, '2026-09-01 00:00:00', 'morning', 1.5, 'buffalo', 72, 108, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(67, 1, 9, '2026-09-08 00:00:00', 'morning', 2, 'cow', 60, 120, 'pending', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(68, 1, 9, '2026-09-08 00:00:00', 'evening', 2, 'cow', 60, 120, 'pending', 'Kamlesh Yadav', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(69, 1, 9, '2026-09-07 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(70, 1, 9, '2026-09-06 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(71, 1, 9, '2026-09-05 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(72, 1, 9, '2026-09-04 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(73, 1, 9, '2026-09-03 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(74, 1, 9, '2026-09-02 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(75, 1, 9, '2026-09-01 00:00:00', 'morning', 2, 'cow', 60, 120, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(76, 1, 10, '2026-09-08 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(77, 1, 10, '2026-09-07 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(78, 1, 10, '2026-09-06 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(79, 1, 10, '2026-09-05 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(80, 1, 10, '2026-09-04 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(81, 1, 10, '2026-09-03 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(82, 1, 10, '2026-09-02 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28'),
(83, 1, 10, '2026-09-01 00:00:00', 'morning', 1, 'cow', 60, 60, 'delivered', 'Suresh Parmar', NULL, '2026-09-08 09:41:28', '2026-09-08 09:41:28');

-- Table structure for `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` enum('in_stock','low_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_dairy_id_foreign` (`dairy_id`),
  CONSTRAINT `products_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `dairy_id`, `name`, `category`, `price`, `unit`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cow Milk (Fresh & Chilled)', 'milk', 60, 'L', 250, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 1, 'Buffalo Milk (Pure Thick)', 'milk', 72, 'L', 180, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(3, 1, 'Fresh Curd / Dahi', 'curd', 80, 'kg', 45, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(4, 1, 'Desi Malai Paneer', 'paneer', 360, 'kg', 25, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(5, 1, 'Pure Desi Danedar Ghee', 'ghee', 650, 'L', 60, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(6, 1, 'Fresh White Butter (Makkhan)', 'butter', 520, 'kg', 15, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(7, 1, 'Spiced Masala Buttermilk (Chaas)', 'buttermilk', 20, 'packet', 100, 'in_stock', '2026-09-08 09:41:27', '2026-09-08 09:41:27');

-- Table structure for `bills`
DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `month_year` varchar(255) NOT NULL,
  `total_litres` decimal(8,2) NOT NULL,
  `milk_rate` decimal(8,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `additional_products_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pending_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('paid','partial','unpaid') NOT NULL DEFAULT 'unpaid',
  `due_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bills_bill_number_unique` (`bill_number`),
  KEY `bills_dairy_id_foreign` (`dairy_id`),
  KEY `bills_customer_id_foreign` (`customer_id`),
  CONSTRAINT `bills_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bills_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `bills`
INSERT INTO `bills` (`id`, `dairy_id`, `customer_id`, `bill_number`, `month_year`, `total_litres`, `milk_rate`, `subtotal`, `additional_products_amount`, `discount_amount`, `total_amount`, `paid_amount`, `pending_amount`, `status`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'INV-202609-101', 'September 2026', 58, 60, 3480, 500, 100, 3880, 3880, 0, 'paid', '2026-09-13 09:41:28', '2026-09-08 09:41:28', '2026-09-08 10:22:49'),
(2, 1, 1, 'INV-202608-101', 'August 2026', 62, 60, 3720, 0, 0, 3720, 3720, 0, 'paid', '2026-08-19 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(3, 1, 2, 'INV-202609-102', 'September 2026', 45, 72, 3240, 0, 0, 3240, 3240, 0, 'paid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(4, 1, 3, 'INV-202609-103', 'September 2026', 90, 60, 5400, 360, 0, 5760, 2700, 3060, 'partial', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(5, 1, 4, 'INV-202609-104', 'September 2026', 60, 72, 4320, 0, 0, 4320, 0, 4320, 'unpaid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(6, 1, 5, 'INV-202609-105', 'September 2026', 30, 60, 1800, 0, 0, 1800, 1800, 0, 'paid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(7, 1, 6, 'INV-202609-106', 'September 2026', 75, 65, 4875, 0, 0, 4875, 2438, 2437, 'partial', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(8, 1, 7, 'INV-202609-107', 'September 2026', 60, 60, 3600, 0, 0, 3600, 0, 3600, 'unpaid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(9, 1, 8, 'INV-202609-108', 'September 2026', 45, 72, 3240, 0, 0, 3240, 3240, 0, 'paid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(10, 1, 9, 'INV-202609-109', 'September 2026', 60, 60, 3600, 0, 0, 3600, 1800, 1800, 'partial', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(11, 1, 10, 'INV-202609-110', 'September 2026', 30, 60, 1800, 0, 0, 1800, 0, 1800, 'unpaid', '2026-09-15 09:41:29', '2026-09-08 09:41:29', '2026-09-08 09:41:29');

-- Table structure for `payments`
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('bill','subscription') NOT NULL DEFAULT 'bill',
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('upi','cash','bank_transfer','online','card') NOT NULL DEFAULT 'upi',
  `payment_date` datetime NOT NULL,
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'approved',
  `proof_image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  KEY `payments_dairy_id_foreign` (`dairy_id`),
  KEY `payments_customer_id_foreign` (`customer_id`),
  KEY `payments_bill_id_foreign` (`bill_id`),
  KEY `payments_subscription_id_foreign` (`subscription_id`),
  CONSTRAINT `payments_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payments`
INSERT INTO `payments` (`id`, `transaction_id`, `reference_no`, `dairy_id`, `customer_id`, `bill_id`, `subscription_id`, `type`, `amount`, `payment_method`, `payment_date`, `status`, `proof_image`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'SUB-AP-20260901', 'UPI/2948291048', 3, NULL, NULL, 3, 'subscription', 499, 'upi', '2026-09-08 05:41:27', 'pending', NULL, 'GPay reference: UPI/2948291048 by Ramesh Joshi', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 'MF202609050012', 'UPI/GPay/9827104928', 1, 1, 1, NULL, 'bill', 2400, 'upi', '2026-09-05 09:41:29', 'approved', NULL, 'Google Pay payment received from Rajesh Sharma', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(3, 'MF202609070088', 'CASH/REC/092', 1, 2, NULL, NULL, 'bill', 2000, 'cash', '2026-09-07 09:41:29', 'approved', NULL, 'Cash received by delivery boy Suresh Parmar', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(4, 'MF202609080005', 'UPI/PhonePe/882194', 1, 3, NULL, NULL, 'bill', 3600, 'upi', '2026-09-08 07:41:29', 'approved', NULL, 'PhonePe QR scan at shop counter', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(5, 'MF202609080135', 'UPI/37889508', 1, 1, 1, NULL, 'bill', 1480, 'upi', '2026-09-08 10:22:49', 'approved', NULL, 'Customer Portal Instant UPI Payment', '2026-09-08 10:22:49', '2026-09-08 10:22:49');

-- Table structure for `staff`
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` enum('manager','delivery_boy','accountant') NOT NULL DEFAULT 'delivery_boy',
  `assigned_area` varchar(255) DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_dairy_id_foreign` (`dairy_id`),
  KEY `staff_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `staff`
INSERT INTO `staff` (`id`, `dairy_id`, `user_id`, `name`, `phone`, `role`, `assigned_area`, `permissions`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Suresh Parmar', '+91 97555 11223', 'delivery_boy', 'Scheme 54 & Vijay Nagar', '[\"view_route\",\"mark_delivery\"]', 'active', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(2, 1, NULL, 'Kamlesh Yadav', '+91 97555 22334', 'delivery_boy', 'Palasia & Rau', '[\"view_route\",\"mark_delivery\"]', 'active', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(3, 1, NULL, 'Manish Saxena', '+91 97555 33445', 'accountant', 'Accounts Office', '[\"billing\",\"payments\",\"reports\"]', 'active', '2026-09-08 09:41:27', '2026-09-08 09:41:27'),
(4, 1, NULL, 'Ritu Dave', '+91 97555 44556', 'manager', 'All Operations', '[\"customers\",\"milk\",\"billing\",\"reports\"]', 'active', '2026-09-08 09:41:27', '2026-09-08 09:41:27');

-- Table structure for `notifications`
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_dairy_id_foreign` (`dairy_id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `notifications`
INSERT INTO `notifications` (`id`, `dairy_id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Daily Milk Dispatched', 'Morning shift delivery started by Suresh Parmar (Scheme 54 route).', 'delivery', 0, '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(2, 1, 2, 'UPI Payment Received ₹2,400', 'Customer Rajesh Sharma paid ₹2,400 via Google Pay.', 'success', 1, '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(3, 1, 3, 'Milk Delivered Successfully', 'Today\'s 2.0 L Cow Milk delivered at 06:45 AM.', 'delivery', 0, '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(4, 1, 3, 'Monthly Bill Generated', 'Your September 2026 bill of ₹3,880 is ready. Pending due: ₹1,480.', 'bill', 0, '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(5, NULL, 1, 'New Dairy Registration Pending', 'Annapurna Dairy (Ujjain) registered for Basic Plan. Payment verification pending.', 'subscription', 0, '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(6, 1, NULL, 'Payment of ₹1480 received', 'Customer Rajesh Sharma paid ₹1480 online via upi. TxID: MF202609080135', 'success', 0, '2026-09-08 10:22:49', '2026-09-08 10:22:49');

-- Table structure for `support_tickets`
DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dairy_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('open','in_progress','resolved') NOT NULL DEFAULT 'open',
  `reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_tickets_dairy_id_foreign` (`dairy_id`),
  KEY `support_tickets_customer_id_foreign` (`customer_id`),
  CONSTRAINT `support_tickets_dairy_id_foreign` FOREIGN KEY (`dairy_id`) REFERENCES `dairies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `support_tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `support_tickets`
INSERT INTO `support_tickets` (`id`, `dairy_id`, `customer_id`, `ticket_number`, `subject`, `message`, `status`, `reply`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'TCK-2026-081', 'Need extra 2L Cow Milk this Sunday (Sept 13)', 'Hello Rajesh ji, we have family guests arriving this Sunday morning. Please deliver 4 Litres instead of regular 2 Litres.', 'resolved', 'Noted Rajesh ji! We have scheduled 4L Cow Milk for Sunday morning Sept 13.', '2026-09-08 09:41:29', '2026-09-08 09:41:29'),
(2, 1, 2, 'TCK-2026-082', 'Pause delivery from Sept 15 to Sept 18', 'Going out of town for 4 days. Please pause delivery during this time.', 'open', NULL, '2026-09-08 09:41:29', '2026-09-08 09:41:29');

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
