import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/dairy_api_service.dart';
import 'login_screen.dart';

class DairySettingsScreen extends StatelessWidget {
  const DairySettingsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final dairy = DairyApiService().currentDairy;

    return Scaffold(
      appBar: AppBar(
        title: const Text('Dairy Profile & Subscription'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            // Dairy Banner
            Center(
              child: Column(
                children: [
                  Container(
                    width: 76,
                    height: 76,
                    decoration: BoxDecoration(
                      color: const Color(0xFF0F172A),
                      borderRadius: BorderRadius.circular(22),
                      border: Border.all(color: AppColors.primary, width: 2),
                    ),
                    child: const Center(
                      child: Icon(Icons.storefront_rounded, size: 40, color: AppColors.primaryLight),
                    ),
                  ),
                  const SizedBox(height: 12),
                  Text(
                    dairy.name,
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    'Proprietor: ${dairy.ownerName} • ${dairy.city}, ${dairy.state}',
                    style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // SaaS Subscription Plan
            _sectionHeader('MilkFlow SaaS Subscription'),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF0F172A), Color(0xFF1E293B)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        dairy.planName,
                        style: const TextStyle(color: Colors.white, fontSize: 16, fontWeight: FontWeight.w800),
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                        decoration: BoxDecoration(
                          color: AppColors.primary,
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: const Text(
                          'ACTIVE PLAN',
                          style: TextStyle(color: Colors.white, fontSize: 10, fontWeight: FontWeight.w800),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  const Text(
                    '✓ Unlimited Route Customers\n✓ Real-time Delivery Tracking\n✓ Instant Online UPI Payments\n✓ Automatic Monthly Invoice Generation',
                    style: TextStyle(color: Colors.white70, fontSize: 12, height: 1.6),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // Shop Contact Details
            _sectionHeader('Store Operations Info'),
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
                  _infoRow('Dairy Helpline', dairy.phone),
                  const Divider(height: 20),
                  _infoRow('Official Email', dairy.email),
                  const Divider(height: 20),
                  _infoRow('City / District', '${dairy.city}, ${dairy.state}'),
                  const Divider(height: 20),
                  _infoRow('Delivery Fleet Staff', '3 Delivery Boys Assigned'),
                  const Divider(height: 20),
                  _infoRow('Active Route Zones', 'Vijay Nagar, Palasia, Scheme 54, Rau'),
                ],
              ),
            ),
            const SizedBox(height: 28),

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
                  'Sign Out of Admin Portal',
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
              'MilkFlow Dairy Admin App v1.0.0\nEnterprise Multi-tenant Architecture',
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
      children: [
        Text(label, style: const TextStyle(fontSize: 13, color: AppColors.textSecondary)),
        Text(value, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
      ],
    );
  }
}
