import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/api_service.dart';
import '../widgets/custom_button.dart';

class ScheduleScreen extends StatefulWidget {
  final int initialTab;
  const ScheduleScreen({super.key, this.initialTab = 0});

  @override
  State<ScheduleScreen> createState() => _ScheduleScreenState();
}

class _ScheduleScreenState extends State<ScheduleScreen> with SingleTickerProviderStateMixin {
  late TabController _tabController;

  // Pause Form State
  DateTime _pauseStartDate = DateTime.now().add(const Duration(days: 1));
  DateTime _pauseEndDate = DateTime.now().add(const Duration(days: 3));
  final _pauseReasonController = TextEditingController(text: 'Family visiting hometown for 3 days.');
  bool _isSubmittingPause = false;

  // Extra Milk Form State
  DateTime _extraDate = DateTime.now().add(const Duration(days: 1));
  double _extraQuantity = 2.0; // Extra litres
  String _extraShift = 'Morning';
  final _extraNoteController = TextEditingController(text: 'Guests visiting home, need fresh milk early morning.');
  bool _isSubmittingExtra = false;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this, initialIndex: widget.initialTab);
  }

  @override
  void dispose() {
    _tabController.dispose();
    _pauseReasonController.dispose();
    _extraNoteController.dispose();
    super.dispose();
  }

  Future<void> _submitPauseRequest() async {
    setState(() => _isSubmittingPause = true);

    final startStr = '${_pauseStartDate.year}-${_pauseStartDate.month.toString().padLeft(2, '0')}-${_pauseStartDate.day.toString().padLeft(2, '0')}';
    final endStr = '${_pauseEndDate.year}-${_pauseEndDate.month.toString().padLeft(2, '0')}-${_pauseEndDate.day.toString().padLeft(2, '0')}';

    final res = await ApiService().requestSchedule(
      requestType: 'pause',
      startDate: startStr,
      endDate: endStr,
      reason: _pauseReasonController.text.trim(),
    );

    setState(() => _isSubmittingPause = false);

    if (mounted) {
      showDialog(
        context: context,
        builder: (_) => AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
          title: const Row(
            children: [
              Icon(Icons.check_circle_rounded, color: AppColors.primary, size: 24),
              SizedBox(width: 8),
              Text('Pause Request Sent'),
            ],
          ),
          content: Text(res['message'] ?? 'Your vacation pause request has been forwarded to your dairy owner.'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('OK', style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.primary)),
            ),
          ],
        ),
      );
    }
  }

  Future<void> _submitExtraMilkRequest() async {
    setState(() => _isSubmittingExtra = true);

    final dateStr = '${_extraDate.year}-${_extraDate.month.toString().padLeft(2, '0')}-${_extraDate.day.toString().padLeft(2, '0')}';

    final res = await ApiService().requestSchedule(
      requestType: 'extra',
      effectiveDate: dateStr,
      newQuantity: _extraQuantity,
      reason: '${_extraShift} shift: ${_extraNoteController.text.trim()}',
    );

    setState(() => _isSubmittingExtra = false);

    if (mounted) {
      showDialog(
        context: context,
        builder: (_) => AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
          title: const Row(
            children: [
              Icon(Icons.check_circle_rounded, color: AppColors.primary, size: 24),
              SizedBox(width: 8),
              Text('Extra Milk Scheduled'),
            ],
          ),
          content: Text(res['message'] ?? 'Your extra milk request has been sent to your dairy.'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('OK', style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.primary)),
            ),
          ],
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          Container(
            color: Colors.white,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            child: TabBar(
              controller: _tabController,
              indicatorColor: AppColors.primary,
              labelColor: AppColors.primary,
              unselectedLabelColor: AppColors.textSecondary,
              labelStyle: const TextStyle(fontWeight: FontWeight.w700, fontSize: 13),
              tabs: const [
                Tab(
                  icon: Icon(Icons.pause_circle_outline_rounded),
                  text: 'Vacation Pause',
                ),
                Tab(
                  icon: Icon(Icons.add_shopping_cart_rounded),
                  text: 'Request Extra Milk',
                ),
              ],
            ),
          ),
          Expanded(
            child: TabBarView(
              controller: _tabController,
              children: [
                _buildVacationPauseTab(),
                _buildExtraMilkTab(),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildVacationPauseTab() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Info banner
          Container(
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: AppColors.warningLight,
              borderRadius: BorderRadius.circular(14),
              border: Border.all(color: AppColors.warning.withOpacity(0.3)),
            ),
            child: const Row(
              children: [
                Icon(Icons.info_outline_rounded, color: AppColors.warning, size: 20),
                SizedBox(width: 10),
                Expanded(
                  child: Text(
                    'Going on vacation or out of station? Pause your daily milk deliveries in advance so you are not charged.',
                    style: TextStyle(fontSize: 12, color: Color(0xFF92400E), height: 1.4),
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 20),

          // Date Selectors
          Row(
            children: [
              Expanded(
                child: _datePickerField(
                  label: 'Pause From',
                  date: _pauseStartDate,
                  onSelect: (d) => setState(() => _pauseStartDate = d),
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: _datePickerField(
                  label: 'Resume On',
                  date: _pauseEndDate,
                  onSelect: (d) => setState(() => _pauseEndDate = d),
                ),
              ),
            ],
          ),
          const SizedBox(height: 18),

          const Text(
            'Reason / Instructions',
            style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
          const SizedBox(height: 8),
          TextField(
            controller: _pauseReasonController,
            maxLines: 3,
            decoration: const InputDecoration(
              hintText: 'e.g. Going to village for festival',
            ),
          ),
          const SizedBox(height: 24),

          CustomButton(
            text: 'Submit Vacation Pause Request',
            icon: Icons.pause_circle_filled_rounded,
            backgroundColor: AppColors.danger,
            isLoading: _isSubmittingPause,
            onPressed: _submitPauseRequest,
          ),
          const SizedBox(height: 24),

          // Recent Requests
          const Text(
            'Recent Pause History',
            style: TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
          const SizedBox(height: 10),
          _historyCard(
            title: 'Pause: 04 Sep 2026',
            subtitle: 'Single day pause • Reason: Not required',
            status: 'Approved',
            statusColor: AppColors.primary,
          ),
        ],
      ),
    );
  }

  Widget _buildExtraMilkTab() {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: AppColors.primarySurface,
              borderRadius: BorderRadius.circular(14),
              border: Border.all(color: AppColors.primary.withOpacity(0.3)),
            ),
            child: const Row(
              children: [
                Icon(Icons.add_circle_outline_rounded, color: AppColors.primary, size: 20),
                SizedBox(width: 10),
                Expanded(
                  child: Text(
                    'Need extra litres for guests, puja, or celebration? Request extra milk for any upcoming morning or evening shift.',
                    style: TextStyle(fontSize: 12, color: AppColors.primaryDark, height: 1.4),
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 20),

          // Date Selector
          _datePickerField(
            label: 'Delivery Date Needed',
            date: _extraDate,
            onSelect: (d) => setState(() => _extraDate = d),
          ),
          const SizedBox(height: 18),

          // Shift Choice
          const Text(
            'Shift Required',
            style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
          const SizedBox(height: 8),
          Row(
            children: [
              Expanded(
                child: _shiftChoiceChip('Morning', Icons.wb_sunny_rounded),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: _shiftChoiceChip('Evening', Icons.nightlight_round),
              ),
            ],
          ),
          const SizedBox(height: 18),

          // Extra Litres Quantity
          const Text(
            'Extra Quantity Needed (Litres)',
            style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
          const SizedBox(height: 8),
          Row(
            children: [1.0, 2.0, 3.0, 5.0].map((qty) {
              final isSel = _extraQuantity == qty;
              return Expanded(
                child: GestureDetector(
                  onTap: () => setState(() => _extraQuantity = qty),
                  child: Container(
                    margin: const EdgeInsets.symmetric(horizontal: 4),
                    padding: const EdgeInsets.symmetric(vertical: 12),
                    decoration: BoxDecoration(
                      color: isSel ? AppColors.primary : Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: isSel ? AppColors.primary : AppColors.border),
                    ),
                    child: Center(
                      child: Text(
                        '+${qty.toStringAsFixed(0)} L',
                        style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: isSel ? Colors.white : AppColors.textPrimary,
                        ),
                      ),
                    ),
                  ),
                ),
              );
            }).toList(),
          ),
          const SizedBox(height: 18),

          const Text(
            'Special Instructions (Optional)',
            style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
          ),
          const SizedBox(height: 8),
          TextField(
            controller: _extraNoteController,
            maxLines: 2,
            decoration: const InputDecoration(
              hintText: 'e.g. Please deliver in separate can',
            ),
          ),
          const SizedBox(height: 24),

          CustomButton(
            text: 'Schedule Extra ${_extraQuantity.toStringAsFixed(0)} Litres Milk',
            icon: Icons.check_circle_rounded,
            isLoading: _isSubmittingExtra,
            onPressed: _submitExtraMilkRequest,
          ),
        ],
      ),
    );
  }

  Widget _shiftChoiceChip(String shift, IconData icon) {
    final isSel = _extraShift == shift;
    return GestureDetector(
      onTap: () => setState(() => _extraShift = shift),
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
        decoration: BoxDecoration(
          color: isSel ? AppColors.primarySurface : Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: isSel ? AppColors.primary : AppColors.border,
            width: isSel ? 2 : 1,
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(icon, size: 18, color: isSel ? AppColors.primary : AppColors.textSecondary),
            const SizedBox(width: 8),
            Text(
              shift,
              style: TextStyle(
                fontWeight: FontWeight.w700,
                color: isSel ? AppColors.primaryDark : AppColors.textPrimary,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _datePickerField({
    required String label,
    required DateTime date,
    required Function(DateTime) onSelect,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
        ),
        const SizedBox(height: 8),
        InkWell(
          onTap: () async {
            final picked = await showDatePicker(
              context: context,
              initialDate: date,
              firstDate: DateTime.now(),
              lastDate: DateTime.now().add(const Duration(days: 60)),
            );
            if (picked != null) onSelect(picked);
          },
          borderRadius: BorderRadius.circular(12),
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 14),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: AppColors.border),
            ),
            child: Row(
              children: [
                const Icon(Icons.calendar_today_rounded, size: 16, color: AppColors.primary),
                const SizedBox(width: 8),
                Text(
                  '${date.day.toString().padLeft(2, '0')}/${date.month.toString().padLeft(2, '0')}/${date.year}',
                  style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _historyCard({
    required String title,
    required String subtitle,
    required String status,
    required Color statusColor,
  }) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: AppColors.border),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
              ),
              const SizedBox(height: 2),
              Text(
                subtitle,
                style: const TextStyle(fontSize: 11, color: AppColors.textSecondary),
              ),
            ],
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
            decoration: BoxDecoration(
              color: statusColor.withOpacity(0.12),
              borderRadius: BorderRadius.circular(6),
            ),
            child: Text(
              status.toUpperCase(),
              style: TextStyle(fontSize: 10, fontWeight: FontWeight.w700, color: statusColor),
            ),
          ),
        ],
      ),
    );
  }
}
