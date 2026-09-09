import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/bill_model.dart';
import '../services/api_service.dart';
import '../widgets/shift_badge.dart';
import '../widgets/custom_button.dart';
import 'payment_screen.dart';

class BillsScreen extends StatefulWidget {
  const BillsScreen({super.key});

  @override
  State<BillsScreen> createState() => _BillsScreenState();
}

class _BillsScreenState extends State<BillsScreen> {
  bool _isLoading = true;
  List<BillModel> _bills = [];

  @override
  void initState() {
    super.initState();
    _fetchBills();
  }

  Future<void> _fetchBills() async {
    setState(() => _isLoading = true);
    final bills = await ApiService().getBills();
    if (mounted) {
      setState(() {
        _bills = bills;
        _isLoading = false;
      });
    }
  }

  void _showInvoiceDetails(BillModel bill) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return Container(
          decoration: const BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
          ),
          padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 20),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Center(
                child: Container(
                  width: 40,
                  height: 4,
                  decoration: BoxDecoration(
                    color: AppColors.border,
                    borderRadius: BorderRadius.circular(2),
                  ),
                ),
              ),
              const SizedBox(height: 18),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Tax Invoice Details',
                        style: TextStyle(fontSize: 18, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                      ),
                      const SizedBox(height: 2),
                      Text(
                        bill.billNumber,
                        style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: AppColors.textMuted),
                      ),
                    ],
                  ),
                  ShiftBadge(text: bill.status, isShift: false),
                ],
              ),
              const SizedBox(height: 20),
              const Divider(height: 1),
              const SizedBox(height: 16),

              // Itemized Breakdown
              _invoiceRow(
                'Milk Supply (${bill.totalLitres.toStringAsFixed(1)} L × ₹${bill.milkRate.toStringAsFixed(0)})',
                '₹${bill.subtotal.toStringAsFixed(0)}',
              ),
              if (bill.additionalProductsAmount > 0) ...[
                const SizedBox(height: 10),
                _invoiceRow(
                  'Additional Dairy Products (Ghee/Paneer)',
                  '+₹${bill.additionalProductsAmount.toStringAsFixed(0)}',
                  isAccent: true,
                ),
              ],
              if (bill.discountAmount > 0) ...[
                const SizedBox(height: 10),
                _invoiceRow(
                  'Prompt Payment / Special Discount',
                  '-₹${bill.discountAmount.toStringAsFixed(0)}',
                  isDiscount: true,
                ),
              ],
              const SizedBox(height: 14),
              const Divider(height: 1),
              const SizedBox(height: 14),

              // Totals
              _invoiceRow(
                'Total Invoiced Amount',
                '₹${bill.totalAmount.toStringAsFixed(0)}',
                isBold: true,
              ),
              const SizedBox(height: 10),
              _invoiceRow(
                'Amount Already Paid',
                '₹${bill.paidAmount.toStringAsFixed(0)}',
                color: AppColors.primary,
              ),
              const SizedBox(height: 10),
              _invoiceRow(
                'Balance Outstanding',
                '₹${bill.pendingAmount.toStringAsFixed(0)}',
                isBold: true,
                color: bill.pendingAmount > 0 ? AppColors.danger : AppColors.primary,
              ),
              const SizedBox(height: 24),

              if (bill.pendingAmount > 0)
                CustomButton(
                  text: 'Pay Remaining ₹${bill.pendingAmount.toStringAsFixed(0)} via UPI',
                  icon: Icons.payments_rounded,
                  onPressed: () {
                    Navigator.pop(context);
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (_) => PaymentScreen(
                          billId: bill.id,
                          pendingAmount: bill.pendingAmount,
                        ),
                      ),
                    ).then((_) => _fetchBills());
                  },
                )
              else
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(14),
                  decoration: BoxDecoration(
                    color: AppColors.primarySurface,
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: const Center(
                    child: Text(
                      '✓ Invoice Fully Settled',
                      style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.primaryDark),
                    ),
                  ),
                ),
              const SizedBox(height: 16),
            ],
          ),
        );
      },
    );
  }

  Widget _invoiceRow(
    String title,
    String value, {
    bool isBold = false,
    bool isDiscount = false,
    bool isAccent = false,
    Color? color,
  }) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Expanded(
          child: Text(
            title,
            style: TextStyle(
              fontSize: 13,
              fontWeight: isBold ? FontWeight.w700 : FontWeight.w500,
              color: isDiscount ? AppColors.success : (isBold ? AppColors.textPrimary : AppColors.textSecondary),
            ),
          ),
        ),
        Text(
          value,
          style: TextStyle(
            fontSize: isBold ? 15 : 13,
            fontWeight: isBold ? FontWeight.w800 : FontWeight.w600,
            color: color ?? (isDiscount ? AppColors.success : AppColors.textPrimary),
          ),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Center(child: CircularProgressIndicator(color: AppColors.primary));
    }

    final totalOutstanding = _bills.fold(0.0, (acc, b) => acc + b.pendingAmount);

    return RefreshIndicator(
      onRefresh: _fetchBills,
      color: AppColors.primary,
      child: SingleChildScrollView(
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Outstanding Card
            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: totalOutstanding > 0 ? const Color(0xFFFFFBEB) : AppColors.primarySurface,
                borderRadius: BorderRadius.circular(20),
                border: Border.all(
                  color: totalOutstanding > 0 ? const Color(0xFFFDE68A) : AppColors.primary.withOpacity(0.3),
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
                          const Text(
                            'Total Outstanding Dues',
                            style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600, color: AppColors.textSecondary),
                          ),
                          const SizedBox(height: 6),
                          Text(
                            '₹${totalOutstanding.toStringAsFixed(0)}',
                            style: TextStyle(
                              fontSize: 32,
                              fontWeight: FontWeight.w800,
                              color: totalOutstanding > 0 ? const Color(0xFFB45309) : AppColors.primaryDark,
                              letterSpacing: -0.5,
                            ),
                          ),
                        ],
                      ),
                      Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          shape: BoxShape.circle,
                          boxShadow: const [
                            BoxShadow(color: AppColors.cardShadow, blurRadius: 6, offset: Offset(0, 2)),
                          ],
                        ),
                        child: Icon(
                          totalOutstanding > 0 ? Icons.pending_actions_rounded : Icons.check_circle_rounded,
                          color: totalOutstanding > 0 ? AppColors.warning : AppColors.primary,
                          size: 28,
                        ),
                      ),
                    ],
                  ),
                  if (totalOutstanding > 0) ...[
                    const SizedBox(height: 16),
                    CustomButton(
                      text: 'Pay All Dues Now (UPI)',
                      icon: Icons.flash_on_rounded,
                      backgroundColor: const Color(0xFFD97706),
                      onPressed: () {
                        final unpaidBill = _bills.firstWhere(
                          (b) => b.pendingAmount > 0,
                          orElse: () => _bills.first,
                        );
                        Navigator.of(context).push(
                          MaterialPageRoute(
                            builder: (_) => PaymentScreen(
                              billId: unpaidBill.id,
                              pendingAmount: totalOutstanding,
                            ),
                          ),
                        ).then((_) => _fetchBills());
                      },
                    ),
                  ],
                ],
              ),
            ),
            const SizedBox(height: 22),

            // Billing History Header
            const Text(
              'Invoice History',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
            ),
            const SizedBox(height: 12),

            ListView.separated(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              itemCount: _bills.length,
              separatorBuilder: (_, __) => const SizedBox(height: 12),
              itemBuilder: (context, index) {
                final bill = _bills[index];
                return InkWell(
                  onTap: () => _showInvoiceDetails(bill),
                  borderRadius: BorderRadius.circular(16),
                  child: Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(color: AppColors.border),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Row(
                              children: [
                                const Icon(Icons.receipt_long_rounded, size: 20, color: AppColors.primary),
                                const SizedBox(width: 8),
                                Text(
                                  bill.monthYear,
                                  style: const TextStyle(
                                    fontSize: 15,
                                    fontWeight: FontWeight.w700,
                                    color: AppColors.textPrimary,
                                  ),
                                ),
                              ],
                            ),
                            ShiftBadge(text: bill.status, isShift: false),
                          ],
                        ),
                        const SizedBox(height: 12),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  '${bill.totalLitres.toStringAsFixed(1)} Litres Delivered',
                                  style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                                ),
                                const SizedBox(height: 2),
                                Text(
                                  'Due Date: ${bill.dueDate}',
                                  style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                ),
                              ],
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  '₹${bill.totalAmount.toStringAsFixed(0)}',
                                  style: const TextStyle(
                                    fontSize: 16,
                                    fontWeight: FontWeight.w800,
                                    color: AppColors.textPrimary,
                                  ),
                                ),
                                if (bill.pendingAmount > 0)
                                  Text(
                                    'Due: ₹${bill.pendingAmount.toStringAsFixed(0)}',
                                    style: const TextStyle(
                                      fontSize: 11,
                                      fontWeight: FontWeight.w700,
                                      color: AppColors.danger,
                                    ),
                                  )
                                else
                                  const Text(
                                    'Settled',
                                    style: TextStyle(
                                      fontSize: 11,
                                      fontWeight: FontWeight.w600,
                                      color: AppColors.primary,
                                    ),
                                  ),
                              ],
                            ),
                          ],
                        ),
                        const SizedBox(height: 10),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            const Text(
                              'View Detailed Breakdown',
                              style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: AppColors.primary),
                            ),
                            const SizedBox(width: 4),
                            const Icon(Icons.arrow_forward_ios_rounded, size: 10, color: AppColors.primary),
                          ],
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
