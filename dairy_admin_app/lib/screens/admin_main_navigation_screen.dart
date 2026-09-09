import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/dairy_api_service.dart';
import 'dashboard_screen.dart';
import 'daily_milk_entry_screen.dart';
import 'customer_management_screen.dart';
import 'billing_payments_screen.dart';
import 'customer_requests_screen.dart';
import 'dairy_settings_screen.dart';

class AdminMainNavigationScreen extends StatefulWidget {
  const AdminMainNavigationScreen({super.key});

  @override
  State<AdminMainNavigationScreen> createState() => _AdminMainNavigationScreenState();
}

class _AdminMainNavigationScreenState extends State<AdminMainNavigationScreen> {
  int _currentIndex = 0;

  final List<Widget> _screens = const [
    DashboardScreen(),
    DailyMilkEntryScreen(),
    CustomerManagementScreen(),
    BillingPaymentsScreen(),
    CustomerRequestsScreen(),
  ];

  @override
  Widget build(BuildContext context) {
    final dairy = DairyApiService().currentDairy;

    return Scaffold(
      appBar: AppBar(
        titleSpacing: 16,
        title: Row(
          children: [
            Container(
              width: 36,
              height: 36,
              decoration: BoxDecoration(
                color: const Color(0xFF0F172A),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Center(
                child: Icon(Icons.storefront_rounded, size: 20, color: AppColors.primaryLight),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    dairy.name,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                  ),
                  Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 1.5),
                        decoration: BoxDecoration(
                          color: AppColors.primarySurface,
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: Text(
                          dairy.planName.split(' ').first.toUpperCase(),
                          style: const TextStyle(fontSize: 10, fontWeight: FontWeight.w700, color: AppColors.primaryDark),
                        ),
                      ),
                      const SizedBox(width: 6),
                      Text(
                        dairy.ownerName,
                        style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w500, color: AppColors.textSecondary),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
        actions: [
          IconButton(
            icon: Container(
              padding: const EdgeInsets.all(6),
              decoration: BoxDecoration(
                color: AppColors.border.withOpacity(0.5),
                shape: BoxShape.circle,
              ),
              child: const Icon(Icons.settings_outlined, size: 20, color: AppColors.textPrimary),
            ),
            onPressed: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const DairySettingsScreen()),
              );
            },
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: IndexedStack(
        index: _currentIndex,
        children: _screens,
      ),
      bottomNavigationBar: Container(
        decoration: const BoxDecoration(
          color: Colors.white,
          border: Border(top: BorderSide(color: AppColors.border, width: 1)),
        ),
        child: NavigationBar(
          selectedIndex: _currentIndex,
          onDestinationSelected: (idx) => setState(() => _currentIndex = idx),
          backgroundColor: Colors.white,
          indicatorColor: AppColors.primarySurface,
          elevation: 0,
          destinations: const [
            NavigationDestination(
              icon: Icon(Icons.dashboard_outlined),
              selectedIcon: Icon(Icons.dashboard_rounded, color: AppColors.primary),
              label: 'Overview',
            ),
            NavigationDestination(
              icon: Icon(Icons.edit_calendar_outlined),
              selectedIcon: Icon(Icons.edit_calendar_rounded, color: AppColors.primary),
              label: 'Milk Entry',
            ),
            NavigationDestination(
              icon: Icon(Icons.people_alt_outlined),
              selectedIcon: Icon(Icons.people_alt_rounded, color: AppColors.primary),
              label: 'Customers',
            ),
            NavigationDestination(
              icon: Icon(Icons.receipt_long_outlined),
              selectedIcon: Icon(Icons.receipt_long_rounded, color: AppColors.primary),
              label: 'Billing',
            ),
            NavigationDestination(
              icon: Icon(Icons.notifications_active_outlined),
              selectedIcon: Icon(Icons.notifications_active_rounded, color: AppColors.primary),
              label: 'Requests',
            ),
          ],
        ),
      ),
    );
  }
}
