import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/milk_record_model.dart';
import '../services/api_service.dart';
import '../widgets/shift_badge.dart';

class MilkHistoryScreen extends StatefulWidget {
  const MilkHistoryScreen({super.key});

  @override
  State<MilkHistoryScreen> createState() => _MilkHistoryScreenState();
}

class _MilkHistoryScreenState extends State<MilkHistoryScreen> {
  bool _isLoading = true;
  List<MilkRecordModel> _records = [];
  String _selectedFilter = 'all'; // all, delivered, paused

  @override
  void initState() {
    super.initState();
    _fetchRecords();
  }

  Future<void> _fetchRecords() async {
    setState(() => _isLoading = true);
    final list = await ApiService().getMilkRecords();
    if (mounted) {
      setState(() {
        _records = list;
        _isLoading = false;
      });
    }
  }

  List<MilkRecordModel> get _filteredRecords {
    if (_selectedFilter == 'delivered') {
      return _records.where((r) => r.status == 'delivered').toList();
    } else if (_selectedFilter == 'paused') {
      return _records.where((r) => r.status == 'paused' || r.status == 'skipped').toList();
    }
    return _records;
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Center(child: CircularProgressIndicator(color: AppColors.primary));
    }

    final totalLitres = _records.where((r) => r.status == 'delivered').fold(0.0, (acc, r) => acc + r.quantity);
    final deliveredDays = _records.where((r) => r.status == 'delivered').length;
    final pausedDays = _records.where((r) => r.status == 'paused' || r.status == 'skipped').length;

    return RefreshIndicator(
      onRefresh: _fetchRecords,
      color: AppColors.primary,
      child: SingleChildScrollView(
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Month Header & Switcher
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(14),
                border: Border.all(color: AppColors.border),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Row(
                    children: [
                      Icon(Icons.calendar_month_rounded, color: AppColors.primary, size: 20),
                      SizedBox(width: 8),
                      Text(
                        'September 2026',
                        style: TextStyle(fontSize: 15, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                      ),
                    ],
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: AppColors.primarySurface,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Text(
                      'Current Cycle',
                      style: TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.primary),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 14),

            // Monthly Highlights Card
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: AppColors.primarySurface,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.primary.withOpacity(0.2)),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  _SummaryItem(
                    label: 'Total Milk',
                    value: '${totalLitres.toStringAsFixed(1)} L',
                    color: AppColors.primaryDark,
                  ),
                  Container(height: 32, width: 1, color: AppColors.border),
                  _SummaryItem(
                    label: 'Delivered',
                    value: '$deliveredDays Days',
                    color: AppColors.primary,
                  ),
                  Container(height: 32, width: 1, color: AppColors.border),
                  _SummaryItem(
                    label: 'Paused',
                    value: '$pausedDays Days',
                    color: pausedDays > 0 ? AppColors.warning : AppColors.textSecondary,
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),

            // Filter Chips
            Row(
              children: [
                _filterChip('all', 'All Entries (${_records.length})'),
                const SizedBox(width: 8),
                _filterChip('delivered', 'Delivered ($deliveredDays)'),
                const SizedBox(width: 8),
                _filterChip('paused', 'Paused ($pausedDays)'),
              ],
            ),
            const SizedBox(height: 16),

            // Records List
            if (_filteredRecords.isEmpty)
              const Padding(
                padding: EdgeInsets.symmetric(vertical: 40),
                child: Center(
                  child: Text(
                    'No delivery entries match this filter',
                    style: TextStyle(color: AppColors.textMuted),
                  ),
                ),
              )
            else
              ListView.separated(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: _filteredRecords.length,
                separatorBuilder: (_, __) => const SizedBox(height: 10),
                itemBuilder: (context, index) {
                  final item = _filteredRecords[index];
                  final isDelivered = item.status == 'delivered';

                  return Container(
                    padding: const EdgeInsets.all(14),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(14),
                      border: Border.all(color: AppColors.border),
                    ),
                    child: Row(
                      children: [
                        // Day Box
                        Container(
                          width: 48,
                          height: 48,
                          decoration: BoxDecoration(
                            color: isDelivered ? AppColors.primarySurface : AppColors.dangerLight,
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                item.day,
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.w800,
                                  color: isDelivered ? AppColors.primaryDark : AppColors.danger,
                                  height: 1.0,
                                ),
                              ),
                              const SizedBox(height: 2),
                              Text(
                                item.dayName.toUpperCase(),
                                style: TextStyle(
                                  fontSize: 10,
                                  fontWeight: FontWeight.w700,
                                  color: isDelivered ? AppColors.primary : AppColors.danger,
                                ),
                              ),
                            ],
                          ),
                        ),
                        const SizedBox(width: 14),

                        // Details
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                children: [
                                  Text(
                                    item.formattedDate,
                                    style: const TextStyle(
                                      fontSize: 13,
                                      fontWeight: FontWeight.w700,
                                      color: AppColors.textPrimary,
                                    ),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 4),
                              Row(
                                children: [
                                  ShiftBadge(text: item.shift, isShift: true),
                                  const SizedBox(width: 6),
                                  ShiftBadge(text: item.status, isShift: false),
                                ],
                              ),
                            ],
                          ),
                        ),

                        // Amount & Litres
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.end,
                          children: [
                            Text(
                              isDelivered ? '${item.quantity.toStringAsFixed(1)} Litres' : '0.0 Litres',
                              style: const TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.w800,
                                color: AppColors.textPrimary,
                              ),
                            ),
                            const SizedBox(height: 2),
                            Text(
                              isDelivered ? '₹${item.amount.toStringAsFixed(0)} (@₹${item.rate.toStringAsFixed(0)})' : 'No Charge',
                              style: const TextStyle(
                                fontSize: 11,
                                fontWeight: FontWeight.w600,
                                color: AppColors.textMuted,
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  );
                },
              ),
          ],
        ),
      ),
    );
  }

  Widget _filterChip(String key, String label) {
    final isSelected = _selectedFilter == key;
    return GestureDetector(
      onTap: () => setState(() => _selectedFilter = key),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primary : Colors.white,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(
            color: isSelected ? AppColors.primary : AppColors.border,
          ),
        ),
        child: Text(
          label,
          style: TextStyle(
            fontSize: 12,
            fontWeight: isSelected ? FontWeight.w700 : FontWeight.w500,
            color: isSelected ? Colors.white : AppColors.textSecondary,
          ),
        ),
      ),
    );
  }
}

class _SummaryItem extends StatelessWidget {
  final String label;
  final String value;
  final Color color;

  const _SummaryItem({
    required this.label,
    required this.value,
    required this.color,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Text(
          value,
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.w800,
            color: color,
            letterSpacing: -0.5,
          ),
        ),
        const SizedBox(height: 2),
        Text(
          label,
          style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: AppColors.textSecondary),
        ),
      ],
    );
  }
}
