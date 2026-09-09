import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/milk_entry_model.dart';
import '../services/dairy_api_service.dart';
import '../widgets/primary_button.dart';

class DailyMilkEntryScreen extends StatefulWidget {
  const DailyMilkEntryScreen({super.key});

  @override
  State<DailyMilkEntryScreen> createState() => _DailyMilkEntryScreenState();
}

class _DailyMilkEntryScreenState extends State<DailyMilkEntryScreen> {
  String _selectedShift = 'morning'; // morning, evening
  DateTime _selectedDate = DateTime.now();
  bool _isLoading = true;
  List<MilkEntryModel> _roster = [];

  @override
  void initState() {
    super.initState();
    _fetchRoster();
  }

  Future<void> _fetchRoster() async {
    setState(() => _isLoading = true);
    final dateStr = '${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}';
    final roster = await DairyApiService().getMilkEntryRoster(_selectedShift, dateStr);
    if (mounted) {
      setState(() {
        _roster = roster;
        _isLoading = false;
      });
    }
  }

  Future<void> _updateQuantity(MilkEntryModel item, double newQty) async {
    final qty = newQty.clamp(0.0, 20.0);
    setState(() {
      item.recordedQuantity = qty;
      if (qty == 0.0) {
        item.status = 'absent';
      } else if (qty > item.defaultQuantity) {
        item.status = 'extra';
      } else {
        item.status = 'delivered';
      }
    });

    final dateStr = '${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}';
    await DairyApiService().saveMilkEntry(
      customerId: item.customerId,
      shift: _selectedShift,
      date: dateStr,
      quantity: item.recordedQuantity,
      status: item.status,
    );
  }

  Future<void> _setStatus(MilkEntryModel item, String newStatus) async {
    setState(() {
      item.status = newStatus;
      if (newStatus == 'absent') {
        item.recordedQuantity = 0.0;
      } else if (newStatus == 'delivered') {
        item.recordedQuantity = item.defaultQuantity;
      }
    });

    final dateStr = '${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}';
    await DairyApiService().saveMilkEntry(
      customerId: item.customerId,
      shift: _selectedShift,
      date: dateStr,
      quantity: item.recordedQuantity,
      status: item.status,
    );
  }

  Future<void> _markAllDelivered() async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: Text('Mark All ${_selectedShift.toUpperCase()} Deliveries?'),
        content: const Text('This will set default milk quantity as delivered for all active route customers.'),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context, false), child: const Text('Cancel')),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(backgroundColor: AppColors.primary),
            child: const Text('Confirm Mark All'),
          ),
        ],
      ),
    );

    if (confirm == true) {
      final dateStr = '${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}';
      await DairyApiService().batchMarkDelivered(_selectedShift, dateStr);
      await _fetchRoster();

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('All ${_selectedShift} deliveries marked successfully!'),
            backgroundColor: AppColors.primary,
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final totalDeliveredLitres = _roster
        .where((r) => r.status != 'absent' && r.status != 'paused')
        .fold(0.0, (acc, r) => acc + r.recordedQuantity);

    return Scaffold(
      body: Column(
        children: [
          // Shift & Date Selector Header
          Container(
            color: Colors.white,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            child: Column(
              children: [
                Row(
                  children: [
                    // Morning Button
                    Expanded(
                      child: GestureDetector(
                        onTap: () {
                          if (_selectedShift != 'morning') {
                            setState(() => _selectedShift = 'morning');
                            _fetchRoster();
                          }
                        },
                        child: Container(
                          padding: const EdgeInsets.symmetric(vertical: 10),
                          decoration: BoxDecoration(
                            color: _selectedShift == 'morning' ? AppColors.primarySurface : Colors.white,
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(
                              color: _selectedShift == 'morning' ? AppColors.primary : AppColors.border,
                              width: _selectedShift == 'morning' ? 2 : 1,
                            ),
                          ),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.wb_sunny_rounded,
                                size: 18,
                                color: _selectedShift == 'morning' ? AppColors.primary : AppColors.textSecondary,
                              ),
                              const SizedBox(width: 8),
                              Text(
                                'Morning Shift',
                                style: TextStyle(
                                  fontSize: 13,
                                  fontWeight: FontWeight.w700,
                                  color: _selectedShift == 'morning' ? AppColors.primaryDark : AppColors.textSecondary,
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    // Evening Button
                    Expanded(
                      child: GestureDetector(
                        onTap: () {
                          if (_selectedShift != 'evening') {
                            setState(() => _selectedShift = 'evening');
                            _fetchRoster();
                          }
                        },
                        child: Container(
                          padding: const EdgeInsets.symmetric(vertical: 10),
                          decoration: BoxDecoration(
                            color: _selectedShift == 'evening' ? AppColors.purpleSurface : Colors.white,
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(
                              color: _selectedShift == 'evening' ? AppColors.purple : AppColors.border,
                              width: _selectedShift == 'evening' ? 2 : 1,
                            ),
                          ),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.nightlight_round,
                                size: 18,
                                color: _selectedShift == 'evening' ? AppColors.purple : AppColors.textSecondary,
                              ),
                              const SizedBox(width: 8),
                              Text(
                                'Evening Shift',
                                style: TextStyle(
                                  fontSize: 13,
                                  fontWeight: FontWeight.w700,
                                  color: _selectedShift == 'evening' ? AppColors.purple : AppColors.textSecondary,
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),

                // Shift Summary & Batch Mark Bar
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          '${totalDeliveredLitres.toStringAsFixed(1)} Litres Recorded',
                          style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                        ),
                        Text(
                          '${_roster.length} Active Customers in Route',
                          style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                        ),
                      ],
                    ),
                    ElevatedButton.icon(
                      onPressed: _markAllDelivered,
                      icon: const Icon(Icons.done_all_rounded, size: 16),
                      label: const Text('Mark All Delivered', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                        elevation: 0,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          const Divider(height: 1, color: AppColors.border),

          // Roster Entries List
          Expanded(
            child: _isLoading
                ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
                : ListView.separated(
                    padding: const EdgeInsets.all(16),
                    itemCount: _roster.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 12),
                    itemBuilder: (context, index) {
                      final item = _roster[index];
                      final isAbsent = item.status == 'absent';
                      final isDelivered = item.status == 'delivered';
                      final isExtra = item.status == 'extra';

                      return Container(
                        padding: const EdgeInsets.all(14),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(16),
                          border: Border.all(
                            color: isAbsent
                                ? AppColors.danger.withOpacity(0.3)
                                : (isExtra ? AppColors.warning.withOpacity(0.4) : AppColors.border),
                          ),
                        ),
                        child: Column(
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Row(
                                      children: [
                                        Text(
                                          item.name,
                                          style: const TextStyle(
                                            fontSize: 14,
                                            fontWeight: FontWeight.w700,
                                            color: AppColors.textPrimary,
                                          ),
                                        ),
                                        const SizedBox(width: 8),
                                        Container(
                                          padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                          decoration: BoxDecoration(
                                            color: AppColors.background,
                                            borderRadius: BorderRadius.circular(4),
                                          ),
                                          child: Text(
                                            item.customerCode,
                                            style: const TextStyle(fontSize: 10, fontWeight: FontWeight.w700, color: AppColors.textMuted),
                                          ),
                                        ),
                                      ],
                                    ),
                                    const SizedBox(height: 2),
                                    Text(
                                      '${item.area} • ${item.milkType.toUpperCase()} (@₹${item.rate.toStringAsFixed(0)}/L)',
                                      style: const TextStyle(fontSize: 11, color: AppColors.textSecondary),
                                    ),
                                  ],
                                ),
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.end,
                                  children: [
                                    Text(
                                      '₹${(item.recordedQuantity * item.rate).toStringAsFixed(0)}',
                                      style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                                    ),
                                    Text(
                                      'Quota: ${item.defaultQuantity.toStringAsFixed(1)}L',
                                      style: const TextStyle(fontSize: 10, color: AppColors.textMuted),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                            const SizedBox(height: 12),
                            const Divider(height: 1, color: AppColors.divider),
                            const SizedBox(height: 10),

                            // Controls Row: Quantity Stepper & Status Chips
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                // Stepper
                                Container(
                                  decoration: BoxDecoration(
                                    color: AppColors.background,
                                    borderRadius: BorderRadius.circular(10),
                                    border: Border.all(color: AppColors.border),
                                  ),
                                  child: Row(
                                    children: [
                                      IconButton(
                                        icon: const Icon(Icons.remove_rounded, size: 18),
                                        visualDensity: VisualDensity.compact,
                                        onPressed: () => _updateQuantity(item, item.recordedQuantity - 0.5),
                                      ),
                                      Padding(
                                        padding: const EdgeInsets.symmetric(horizontal: 8),
                                        child: Text(
                                          '${item.recordedQuantity.toStringAsFixed(1)} L',
                                          style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                                        ),
                                      ),
                                      IconButton(
                                        icon: const Icon(Icons.add_rounded, size: 18),
                                        visualDensity: VisualDensity.compact,
                                        onPressed: () => _updateQuantity(item, item.recordedQuantity + 0.5),
                                      ),
                                    ],
                                  ),
                                ),

                                // Status Choices
                                Row(
                                  children: [
                                    _statusButton(
                                      label: 'Delivered',
                                      isSelected: isDelivered,
                                      color: AppColors.primary,
                                      onTap: () => _setStatus(item, 'delivered'),
                                    ),
                                    const SizedBox(width: 6),
                                    _statusButton(
                                      label: 'Absent',
                                      isSelected: isAbsent,
                                      color: AppColors.danger,
                                      onTap: () => _setStatus(item, 'absent'),
                                    ),
                                    const SizedBox(width: 6),
                                    _statusButton(
                                      label: 'Extra',
                                      isSelected: isExtra,
                                      color: const Color(0xFFD97706),
                                      onTap: () => _setStatus(item, 'extra'),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ],
                        ),
                      );
                    },
                  ),
          ),
        ],
      ),
    );
  }

  Widget _statusButton({
    required String label,
    required bool isSelected,
    required Color color,
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 7),
        decoration: BoxDecoration(
          color: isSelected ? color : Colors.white,
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: isSelected ? color : AppColors.border),
        ),
        child: Text(
          label,
          style: TextStyle(
            fontSize: 11,
            fontWeight: FontWeight.w700,
            color: isSelected ? Colors.white : AppColors.textSecondary,
          ),
        ),
      ),
    );
  }
}
