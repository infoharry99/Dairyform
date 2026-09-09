import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/api_service.dart';
import 'login_screen.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final customer = ApiService().currentCustomer;

    return Scaffold(
      appBar: AppBar(
        title: const Text('My Profile & Subscription'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            // User Avatar & Name Card
            Center(
              child: Column(
                children: [
                  Container(
                    width: 80,
                    height: 80,
                    decoration: BoxDecoration(
                      color: AppColors.primarySurface,
                      shape: BoxShape.circle,
                      border: Border.all(color: AppColors.primary, width: 2),
                    ),
                    child: Center(
                      child: Text(
                        customer.name.substring(0, 1),
                        style: const TextStyle(fontSize: 32, fontWeight: FontWeight.w800, color: AppColors.primary),
                      ),
                    ),
                  ),
                  const SizedBox(height: 12),
                  Text(
                    customer.name,
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                  ),
                  const SizedBox(height: 4),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: AppColors.primarySurface,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Text(
                      'Customer ID: ${customer.customerCode}',
                      style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.primaryDark),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // Subscription Plan Card
            _sectionHeader('Subscription Details'),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.border),
              ),
              child: Column(
                children: [
                  _infoRow('Daily Quota', '${customer.dailyQuantity.toStringAsFixed(1)} Litres / day'),
                  const Divider(height: 20),
                  _infoRow('Milk Type', customer.milkType),
                  const Divider(height: 20),
                  _infoRow('Delivery Timing', customer.deliveryTime),
                  const Divider(height: 20),
                  _infoRow('Agreed Rate', '₹${customer.ratePerLitre.toStringAsFixed(0)} / Litre'),
                  const Divider(height: 20),
                  _infoRow('Delivery Address', customer.address),
                  const Divider(height: 20),
                  _infoRow('Route Zone', customer.area),
                ],
              ),
            ),
            const SizedBox(height: 20),

            // Dairy Shop Info
            _sectionHeader('Your Dairy Shop Provider'),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.border),
              ),
              child: Column(
                children: [
                  _infoRow('Dairy Name', customer.dairyName),
                  const Divider(height: 20),
                  _infoRow('Helpline Phone', customer.dairyPhone),
                  const Divider(height: 20),
                  _infoRow('Location', 'Anand, Gujarat'),
                  const Divider(height: 20),
                  _infoRow('Platform', 'MilkFlow Verified SaaS Merchant'),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // Logout Button
            SizedBox(
              width: double.infinity,
              child: OutlinedButton.icon(
                onPressed: () {
                  Navigator.of(context).pushAndRemoveUntil(
                    MaterialPageRoute(builder: (_) => const LoginScreen()),
                    (route) => false,
                  );
                },
                icon: const Icon(Icons.logout_rounded, color: AppColors.danger, size: 18),
                label: const Text(
                  'Sign Out of Account',
                  style: TextStyle(color: AppColors.danger, fontWeight: FontWeight.w700),
                ),
                style: OutlinedButton.styleFrom(
                  side: const BorderSide(color: AppColors.danger),
                  padding: const EdgeInsets.symmetric(vertical: 14),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                ),
              ),
            ),
            const SizedBox(height: 16),
            const Text(
              'MilkFlow Customer Mobile App v1.0.0\nProtected by MilkFlow SaaS Multi-tenant Security',
              textAlign: TextAlign.center,
              style: TextStyle(fontSize: 11, color: AppColors.textMuted, height: 1.5),
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }

  Widget _sectionHeader(String title) {
    return Align(
      alignment: Alignment.centerLeft,
      child: Text(
        title,
        style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
      ),
    );
  }

  Widget _infoRow(String label, String value) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: const TextStyle(fontSize: 13, color: AppColors.textSecondary),
        ),
        const SizedBox(width: 16),
        Flexible(
          child: Text(
            value,
            textAlign: TextAlign.right,
            style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
        ),
      ],
    );
  }
}
