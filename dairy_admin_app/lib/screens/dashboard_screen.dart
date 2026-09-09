import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/customer_request_model.dart';
import '../services/dairy_api_service.dart';
import '../widgets/kpi_card.dart';
import '../widgets/status_pill.dart';
import 'daily_milk_entry_screen.dart';
import 'customer_management_screen.dart';
import 'billing_payments_screen.dart';
import 'products_screen.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  bool _isLoading = true;
  Map<String, dynamic> _dashboardData = {};

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() => _isLoading = true);
    final data = await DairyApiService().getDashboard();
    if (mounted) {
      setState(() {
        _dashboardData = data;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Center(child: CircularProgressIndicator(color: AppColors.primary));
    }

    final kpis = _dashboardData['kpis'] ?? {};
    final shifts = _dashboardData['shifts'] ?? {};
    final morning = shifts['morning'] ?? {};
    final evening = shifts['evening'] ?? {};
    final requests = DairyApiService().cachedRequests.take(3).toList();

    return RefreshIndicator(
      onRefresh: _loadData,
      color: AppColors.primary,
      child: SingleChildScrollView(
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Header Banner
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Daily Dairy Operations',
                      style: TextStyle(fontSize: 20, fontWeight: FontWeight.w800, color: AppColors.textPrimary, letterSpacing: -0.5),
                    ),
                    const SizedBox(height: 2),
                    Text(
                      'Today: ${DateTime.now().day} Sep ${DateTime.now().year} • Live Updates',
                      style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                    ),
                  ],
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                  decoration: BoxDecoration(
                    color: AppColors.primarySurface,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: AppColors.primary.withOpacity(0.3)),
                  ),
                  child: const Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Icon(Icons.wifi_tethering_rounded, size: 14, color: AppColors.primary),
                      SizedBox(width: 5),
                      Text(
                        'Store Open',
                        style: TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.primaryDark),
                      ),
                    ],
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),

            // Shifts Overview Hero Card
            Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                color: const Color(0xFF0F172A), // Slate 900
                borderRadius: BorderRadius.circular(20),
                boxShadow: const [
                  BoxShadow(color: AppColors.cardShadow, blurRadius: 16, offset: Offset(0, 6)),
                ],
              ),
              child: Column(
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text(
                        'Daily Delivery Shift Progress',
                        style: TextStyle(color: Colors.white, fontSize: 13, fontWeight: FontWeight.w700),
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.12),
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: Text(
                          '${kpis['delivered_litres'] ?? 412.0} / ${kpis['total_litres_today'] ?? 486.0} L',
                          style: const TextStyle(color: AppColors.primaryLight, fontSize: 11, fontWeight: FontWeight.w800),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 16),
                  Row(
                    children: [
                      // Morning Shift
                      Expanded(
                        child: Container(
                          padding: const EdgeInsets.all(12),
                          decoration: BoxDecoration(
                            color: Colors.white.withOpacity(0.06),
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(color: Colors.white.withOpacity(0.1)),
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Row(
                                children: [
                                  Icon(Icons.wb_sunny_rounded, color: Colors.amberAccent, size: 16),
                                  SizedBox(width: 6),
                                  Text('Morning Shift', style: TextStyle(color: Colors.white70, fontSize: 11, fontWeight: FontWeight.w600)),
                                ],
                              ),
                              const SizedBox(height: 8),
                              Text(
                                '${morning['delivered_litres'] ?? 240.0} L',
                                style: const TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w800),
                              ),
                              const SizedBox(height: 4),
                              const Text('Target: 250 L (96% Done)', style: TextStyle(color: AppColors.primaryLight, fontSize: 10, fontWeight: FontWeight.w600)),
                            ],
                          ),
                        ),
                      ),
                      const SizedBox(width: 12),
                      // Evening Shift
                      Expanded(
                        child: Container(
                          padding: const EdgeInsets.all(12),
                          decoration: BoxDecoration(
                            color: Colors.white.withOpacity(0.06),
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(color: Colors.white.withOpacity(0.1)),
                          ),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Row(
                                children: [
                                  Icon(Icons.nightlight_round, color: Color(0xFFA78BFA), size: 16),
                                  SizedBox(width: 6),
                                  Text('Evening Shift', style: TextStyle(color: Colors.white70, fontSize: 11, fontWeight: FontWeight.w600)),
                                ],
                              ),
                              const SizedBox(height: 8),
                              Text(
                                '${evening['delivered_litres'] ?? 172.0} L',
                                style: const TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w800),
                              ),
                              const SizedBox(height: 4),
                              const Text('Target: 236 L (In Progress)', style: TextStyle(color: Colors.amberAccent, fontSize: 10, fontWeight: FontWeight.w600)),
                            ],
                          ),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            const SizedBox(height: 18),

            // Financial & Operational KPI Grid
            Row(
              children: [
                Expanded(
                  child: KpiCard(
                    title: "Today's Collection",
                    value: '₹${(kpis['today_revenue'] ?? 28450.0).toStringAsFixed(0)}',
                    subtitle: 'Cash + Online UPI',
                    icon: Icons.currency_rupee_rounded,
                    iconColor: AppColors.primary,
                    iconBgColor: AppColors.primarySurface,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: KpiCard(
                    title: 'Customer Dues',
                    value: '₹${(kpis['pending_payments'] ?? 48200.0).toStringAsFixed(0)}',
                    subtitle: 'Pending collections',
                    icon: Icons.pending_actions_rounded,
                    iconColor: const Color(0xFFD97706),
                    iconBgColor: const Color(0xFFFEF3C7),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: KpiCard(
                    title: 'Active Customers',
                    value: '${kpis['active_customers'] ?? 312}',
                    subtitle: '${kpis['total_customers'] ?? 324} Total enrolled',
                    icon: Icons.people_outline_rounded,
                    iconColor: AppColors.accent,
                    iconBgColor: AppColors.accentSurface,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: KpiCard(
                    title: 'Pending Requests',
                    value: '${kpis['pending_requests_count'] ?? 2}',
                    subtitle: 'Vacation pauses / Extra',
                    icon: Icons.notifications_none_rounded,
                    iconColor: const Color(0xFF7C3AED),
                    iconBgColor: const Color(0xFFEDE9FE),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 22),

            // Quick Actions Panel
            const Text(
              'Quick Admin Shortcuts',
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: _AdminShortcut(
                    icon: Icons.edit_calendar_rounded,
                    label: 'Milk Entry',
                    sublabel: 'Daily shift log',
                    color: AppColors.primary,
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(builder: (_) => const DailyMilkEntryScreen()),
                      );
                    },
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: _AdminShortcut(
                    icon: Icons.person_add_alt_1_rounded,
                    label: 'New Customer',
                    sublabel: 'Add to route',
                    color: AppColors.accent,
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(builder: (_) => const CustomerManagementScreen()),
                      );
                    },
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: _AdminShortcut(
                    icon: Icons.point_of_sale_rounded,
                    label: 'Collect Pay',
                    sublabel: 'Cash / UPI entry',
                    color: const Color(0xFFD97706),
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(builder: (_) => const BillingPaymentsScreen()),
                      );
                    },
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: _AdminShortcut(
                    icon: Icons.inventory_2_outlined,
                    label: 'Products',
                    sublabel: 'Rates & stock',
                    color: const Color(0xFF7C3AED),
                    onTap: () {
                      Navigator.of(context).push(
                        MaterialPageRoute(builder: (_) => const ProductsScreen()),
                      );
                    },
                  ),
                ),
              ],
            ),
            const SizedBox(height: 24),

            // Urgent Customer Requests
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text(
                  'Customer Action Requests',
                  style: TextStyle(fontSize: 15, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                ),
                Text(
                  '${requests.length} Pending',
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: AppColors.textMuted),
                ),
              ],
            ),
            const SizedBox(height: 12),
            ListView.separated(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              itemCount: requests.length,
              separatorBuilder: (_, __) => const SizedBox(height: 10),
              itemBuilder: (context, index) {
                final req = requests[index];
                return Container(
                  padding: const EdgeInsets.all(14),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(14),
                    border: Border.all(color: AppColors.border),
                  ),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(10),
                        decoration: BoxDecoration(
                          color: req.subject.contains('Pause') ? AppColors.dangerSurface : AppColors.primarySurface,
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Icon(
                          req.subject.contains('Pause') ? Icons.pause_circle_filled_rounded : Icons.add_circle_rounded,
                          color: req.subject.contains('Pause') ? AppColors.danger : AppColors.primary,
                          size: 20,
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              req.subject,
                              style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                            ),
                            const SizedBox(height: 2),
                            Text(
                              '${req.customerName} (${req.customerCode})',
                              style: const TextStyle(fontSize: 11, color: AppColors.textSecondary),
                            ),
                          ],
                        ),
                      ),
                      StatusPill(status: req.status),
                    ],
                  ),
                );
              },
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }
}

class _AdminShortcut extends StatelessWidget {
  final IconData icon;
  final String label;
  final String sublabel;
  final Color color;
  final VoidCallback onTap;

  const _AdminShortcut({
    required this.icon,
    required this.label,
    required this.sublabel,
    required this.color,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(14),
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 8),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(14),
          border: Border.all(color: AppColors.border),
        ),
        child: Column(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: color.withOpacity(0.12),
                shape: BoxShape.circle,
              ),
              child: Icon(icon, size: 18, color: color),
            ),
            const SizedBox(height: 8),
            Text(
              label,
              style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
              textAlign: TextAlign.center,
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
            const SizedBox(height: 2),
            Text(
              sublabel,
              style: const TextStyle(fontSize: 9, color: AppColors.textMuted),
              textAlign: TextAlign.center,
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
          ],
        ),
      ),
    );
  }
}
