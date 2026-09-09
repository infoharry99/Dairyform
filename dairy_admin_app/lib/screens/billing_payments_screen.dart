import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/admin_bill_model.dart';
import '../models/customer_summary_model.dart';
import '../services/dairy_api_service.dart';
import '../widgets/primary_button.dart';
import '../widgets/status_pill.dart';

class BillingPaymentsScreen extends StatefulWidget {
  const BillingPaymentsScreen({super.key});

  @override
  State<BillingPaymentsScreen> createState() => _BillingPaymentsScreenState();
}

class _BillingPaymentsScreenState extends State<BillingPaymentsScreen> {
  bool _isLoading = true;
  List<AdminBillModel> _bills = [];
  bool _isGenerating = false;

  @override
  void initState() {
    super.initState();
    _fetchBills();
  }

  Future<void> _fetchBills() async {
    setState(() => _isLoading = true);
    final list = await DairyApiService().getBills();
    if (mounted) {
      setState(() {
        _bills = list;
        _isLoading = false;
      });
    }
  }

  Future<void> _generateMonthlyBills() async {
    setState(() => _isGenerating = true);
    final res = await DairyApiService().generateBills('September 2026');
    setState(() => _isGenerating = false);

    if (mounted) {
      _fetchBills();
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(res['message'] ?? 'Monthly bills generated!'),
          backgroundColor: AppColors.primary,
        ),
      );
    }
  }

  void _showRecordPaymentModal() {
    final customers = DairyApiService().cachedCustomers;
    CustomerSummaryModel selectedCustomer = customers.first;
    final amountController = TextEditingController(text: selectedCustomer.pendingDue > 0 ? selectedCustomer.pendingDue.toStringAsFixed(0) : '1000');
    String method = 'cash'; // cash, upi, cheque
    final noteController = TextEditingController(text: 'Received at milk collection center');

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return StatefulBuilder(
          builder: (context, setModalState) {
            return Padding(
              padding: EdgeInsets.only(bottom: MediaQuery.of(context).viewInsets.bottom),
              child: Container(
                decoration: const BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
                ),
                padding: const EdgeInsets.all(22),
                child: SingleChildScrollView(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Center(
                        child: Container(width: 40, height: 4, decoration: BoxDecoration(color: AppColors.border, borderRadius: BorderRadius.circular(2))),
                      ),
                      const SizedBox(height: 16),
                      const Text('Record Offline / Cash Payment', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w800, color: AppColors.textPrimary)),
                      const SizedBox(height: 4),
                      const Text('Collect bill dues and instantly update customer balance', style: TextStyle(fontSize: 12, color: AppColors.textSecondary)),
                      const SizedBox(height: 18),

                      const Text('Select Customer', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 14),
                        decoration: BoxDecoration(border: Border.all(color: AppColors.border), borderRadius: BorderRadius.circular(12)),
                        child: DropdownButtonHideUnderline(
                          child: DropdownButton<CustomerSummaryModel>(
                            value: selectedCustomer,
                            isExpanded: true,
                            items: customers.map((c) {
                              return DropdownMenuItem(
                                value: c,
                                child: Text('${c.name} (${c.customerCode}) - Due: ₹${c.pendingDue.toStringAsFixed(0)}', style: const TextStyle(fontSize: 13)),
                              );
                            }).toList(),
                            onChanged: (val) {
                              if (val != null) {
                                setModalState(() {
                                  selectedCustomer = val;
                                  amountController.text = val.pendingDue > 0 ? val.pendingDue.toStringAsFixed(0) : '1000';
                                });
                              }
                            },
                          ),
                        ),
                      ),
                      const SizedBox(height: 14),

                      const Text('Collected Amount (₹)', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      TextField(
                        controller: amountController,
                        keyboardType: TextInputType.number,
                        style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w800),
                        decoration: const InputDecoration(prefixIcon: Icon(Icons.currency_rupee_rounded, size: 20)),
                      ),
                      const SizedBox(height: 14),

                      const Text('Payment Mode', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      Row(
                        children: [
                          _modeChip('cash', 'Cash', Icons.money_rounded, method, (m) => setModalState(() => method = m)),
                          const SizedBox(width: 8),
                          _modeChip('upi', 'UPI / QR', Icons.qr_code_scanner_rounded, method, (m) => setModalState(() => method = m)),
                          const SizedBox(width: 8),
                          _modeChip('cheque', 'Bank', Icons.account_balance_rounded, method, (m) => setModalState(() => method = m)),
                        ],
                      ),
                      const SizedBox(height: 14),

                      const Text('Notes / Reference', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      TextField(controller: noteController, decoration: const InputDecoration(hintText: 'e.g. Paid in cash to delivery boy')),
                      const SizedBox(height: 24),

                      PrimaryButton(
                        text: 'Record Payment & Settle Dues',
                        icon: Icons.check_circle_rounded,
                        onPressed: () async {
                          final amt = double.tryParse(amountController.text.trim()) ?? 0.0;
                          if (amt <= 0) return;

                          final res = await DairyApiService().recordPayment(
                            customerId: selectedCustomer.id,
                            amount: amt,
                            paymentMethod: method,
                            notes: noteController.text.trim(),
                          );

                          if (mounted) {
                            Navigator.pop(context);
                            _fetchBills();
                            ScaffoldMessenger.of(context).showSnackBar(
                              SnackBar(content: Text(res['message'] ?? 'Payment recorded!'), backgroundColor: AppColors.primary),
                            );
                          }
                        },
                      ),
                      const SizedBox(height: 14),
                    ],
                  ),
                ),
              ),
            );
          },
        );
      },
    );
  }

  Widget _modeChip(String key, String label, IconData icon, String current, Function(String) onSelect) {
    final isSel = key == current;
    return Expanded(
      child: GestureDetector(
        onTap: () => onSelect(key),
        child: Container(
          padding: const EdgeInsets.symmetric(vertical: 10),
          decoration: BoxDecoration(
            color: isSel ? AppColors.primarySurface : Colors.white,
            borderRadius: BorderRadius.circular(10),
            border: Border.all(color: isSel ? AppColors.primary : AppColors.border, width: isSel ? 2 : 1),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(icon, size: 16, color: isSel ? AppColors.primary : AppColors.textSecondary),
              const SizedBox(width: 6),
              Text(
                label,
                style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: isSel ? AppColors.primaryDark : AppColors.textPrimary),
              ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final totalBilled = _bills.fold(0.0, (acc, b) => acc + b.totalAmount);
    final totalCollected = _bills.fold(0.0, (acc, b) => acc + b.paidAmount);
    final totalPending = _bills.fold(0.0, (acc, b) => acc + b.pendingAmount);

    return Scaffold(
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Top Action Banner
            Row(
              children: [
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: _showRecordPaymentModal,
                    icon: const Icon(Icons.point_of_sale_rounded, size: 18),
                    label: const Text('Record Payment', style: TextStyle(fontWeight: FontWeight.w700, fontSize: 13)),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.primary,
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(vertical: 12),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                      elevation: 0,
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: _isGenerating ? null : _generateMonthlyBills,
                    icon: _isGenerating
                        ? const SizedBox(width: 14, height: 14, child: CircularProgressIndicator(strokeWidth: 2))
                        : const Icon(Icons.receipt_long_rounded, size: 18),
                    label: const Text('Generate Bills', style: TextStyle(fontWeight: FontWeight.w700, fontSize: 13)),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: const Color(0xFF0F172A),
                      side: const BorderSide(color: AppColors.border, width: 1.5),
                      padding: const EdgeInsets.symmetric(vertical: 12),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),

            // Billing Summary Metrics
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.border),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  _statItem('Total Invoiced', '₹${totalBilled.toStringAsFixed(0)}', AppColors.textPrimary),
                  Container(height: 32, width: 1, color: AppColors.divider),
                  _statItem('Collected', '₹${totalCollected.toStringAsFixed(0)}', AppColors.primary),
                  Container(height: 32, width: 1, color: AppColors.divider),
                  _statItem('Outstanding', '₹${totalPending.toStringAsFixed(0)}', AppColors.danger),
                ],
              ),
            ),
            const SizedBox(height: 20),

            const Text(
              'Monthly Invoices Roster',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
            ),
            const SizedBox(height: 12),

            if (_isLoading)
              const Center(child: CircularProgressIndicator(color: AppColors.primary))
            else
              ListView.separated(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: _bills.length,
                separatorBuilder: (_, __) => const SizedBox(height: 10),
                itemBuilder: (context, index) {
                  final b = _bills[index];
                  return Container(
                    padding: const EdgeInsets.all(14),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(14),
                      border: Border.all(color: AppColors.border),
                    ),
                    child: Column(
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  b.customerName,
                                  style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                                ),
                                Text(
                                  '${b.customerCode} • ${b.billNumber}',
                                  style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                ),
                              ],
                            ),
                            StatusPill(status: b.status),
                          ],
                        ),
                        const SizedBox(height: 10),
                        const Divider(height: 1, color: AppColors.divider),
                        const SizedBox(height: 8),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(
                              '${b.totalLitres.toStringAsFixed(1)}L (${b.monthYear})',
                              style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                            ),
                            Row(
                              children: [
                                Text(
                                  'Total: ₹${b.totalAmount.toStringAsFixed(0)}',
                                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: AppColors.textPrimary),
                                ),
                                const SizedBox(width: 10),
                                Text(
                                  b.pendingAmount > 0 ? 'Due: ₹${b.pendingAmount.toStringAsFixed(0)}' : 'Paid',
                                  style: TextStyle(
                                    fontSize: 13,
                                    fontWeight: FontWeight.w800,
                                    color: b.pendingAmount > 0 ? AppColors.danger : AppColors.primary,
                                  ),
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
          ],
        ),
      ),
    );
  }

  Widget _statItem(String label, String val, Color color) {
    return Column(
      children: [
        Text(val, style: TextStyle(fontSize: 16, fontWeight: FontWeight.w800, color: color, letterSpacing: -0.5)),
        const SizedBox(height: 2),
        Text(label, style: const TextStyle(fontSize: 10, fontWeight: FontWeight.w600, color: AppColors.textMuted)),
      ],
    );
  }
}
