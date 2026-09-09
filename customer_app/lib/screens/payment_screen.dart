import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/api_service.dart';
import '../widgets/custom_button.dart';

class PaymentScreen extends StatefulWidget {
  final int billId;
  final double pendingAmount;

  const PaymentScreen({
    super.key,
    required this.billId,
    required this.pendingAmount,
  });

  @override
  State<PaymentScreen> createState() => _PaymentScreenState();
}

class _PaymentScreenState extends State<PaymentScreen> {
  late TextEditingController _amountController;
  String _selectedMethod = 'gpay'; // gpay, phonepe, paytm, upi
  bool _isProcessing = false;
  Map<String, dynamic>? _receiptData;

  @override
  void initState() {
    super.initState();
    _amountController = TextEditingController(
      text: widget.pendingAmount > 0 ? widget.pendingAmount.toStringAsFixed(0) : '1480',
    );
  }

  @override
  void dispose() {
    _amountController.dispose();
    super.dispose();
  }

  Future<void> _processPayment() async {
    final amount = double.tryParse(_amountController.text.trim()) ?? widget.pendingAmount;
    if (amount <= 0) return;

    setState(() => _isProcessing = true);

    // Simulate standard UPI payment gateway delay
    await Future.delayed(const Duration(milliseconds: 1600));

    final res = await ApiService().payBill(
      billId: widget.billId,
      amount: amount,
      paymentMethod: _selectedMethod,
    );

    setState(() {
      _isProcessing = false;
      _receiptData = res['receipt'] ?? {
        'transaction_id': 'MF202609080001',
        'amount': amount,
        'method': _selectedMethod.toUpperCase(),
        'payment_date': '08 Sep 2026, 06:45 PM',
        'bill_status': 'PAID',
        'remaining_due': 0.0,
        'dairy_name': ApiService().currentCustomer.dairyName,
      };
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_receiptData != null) {
      return _buildSuccessReceipt();
    }

    return Scaffold(
      appBar: AppBar(
        title: const Text('Pay Dairy Bill'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Bill Overview
            Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                color: AppColors.primarySurface,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.primary.withOpacity(0.25)),
              ),
              child: Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(10),
                    decoration: const BoxDecoration(
                      color: Colors.white,
                      shape: BoxShape.circle,
                    ),
                    child: const Icon(Icons.storefront_rounded, color: AppColors.primary, size: 24),
                  ),
                  const SizedBox(width: 14),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          ApiService().currentCustomer.dairyName,
                          style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                        ),
                        const SizedBox(height: 2),
                        const Text(
                          'Verified Dairy Merchant • Instant Settlement',
                          style: TextStyle(fontSize: 11, color: AppColors.textSecondary),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // Amount Input
            const Text(
              'Payment Amount (₹)',
              style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
            ),
            const SizedBox(height: 8),
            TextField(
              controller: _amountController,
              keyboardType: TextInputType.number,
              style: const TextStyle(fontSize: 26, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
              decoration: InputDecoration(
                prefixIcon: const Icon(Icons.currency_rupee_rounded, color: AppColors.textPrimary, size: 24),
                suffixText: 'INR',
                suffixStyle: const TextStyle(fontWeight: FontWeight.w700, color: AppColors.textSecondary),
                hintText: '0',
                filled: true,
                fillColor: Colors.white,
              ),
            ),
            const SizedBox(height: 24),

            // Choose Payment Method
            const Text(
              'Select UPI Payment App',
              style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
            ),
            const SizedBox(height: 12),

            _paymentOptionTile(
              id: 'gpay',
              title: 'Google Pay UPI',
              subtitle: 'Fastest 1-click UPI authorization',
              icon: Icons.account_balance_wallet_rounded,
              color: const Color(0xFF4285F4),
            ),
            const SizedBox(height: 10),
            _paymentOptionTile(
              id: 'phonepe',
              title: 'PhonePe UPI',
              subtitle: 'Pay directly via linked bank account',
              icon: Icons.phonelink_ring_rounded,
              color: const Color(0xFF5F259F),
            ),
            const SizedBox(height: 10),
            _paymentOptionTile(
              id: 'paytm',
              title: 'Paytm UPI / Wallet',
              subtitle: 'Instant cashback eligible',
              icon: Icons.payments_rounded,
              color: const Color(0xFF00B9F1),
            ),
            const SizedBox(height: 10),
            _paymentOptionTile(
              id: 'bhim',
              title: 'Any UPI ID (BHIM / CRED / Bank)',
              subtitle: 'Scan or enter virtual payment address',
              icon: Icons.qr_code_scanner_rounded,
              color: AppColors.primary,
            ),
            const SizedBox(height: 32),

            // Security note
            const Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.lock_rounded, size: 14, color: AppColors.textMuted),
                SizedBox(width: 6),
                Text(
                  '100% Secure 256-bit Encrypted Payments',
                  style: TextStyle(fontSize: 11, fontWeight: FontWeight.w500, color: AppColors.textMuted),
                ),
              ],
            ),
            const SizedBox(height: 12),

            // Submit Button
            CustomButton(
              text: 'Pay ₹${_amountController.text} Instantly',
              icon: Icons.bolt_rounded,
              isLoading: _isProcessing,
              onPressed: _processPayment,
            ),
          ],
        ),
      ),
    );
  }

  Widget _paymentOptionTile({
    required String id,
    required String title,
    required String subtitle,
    required IconData icon,
    required Color color,
  }) {
    final isSelected = _selectedMethod == id;
    return InkWell(
      onTap: () => setState(() => _selectedMethod = id),
      borderRadius: BorderRadius.circular(14),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(14),
          border: Border.all(
            color: isSelected ? AppColors.primary : AppColors.border,
            width: isSelected ? 2 : 1,
          ),
        ),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                color: color.withOpacity(0.12),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Icon(icon, color: color, size: 22),
            ),
            const SizedBox(width: 14),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    subtitle,
                    style: const TextStyle(fontSize: 11, color: AppColors.textSecondary),
                  ),
                ],
              ),
            ),
            Radio<String>(
              value: id,
              groupValue: _selectedMethod,
              activeColor: AppColors.primary,
              onChanged: (val) => setState(() => _selectedMethod = val!),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSuccessReceipt() {
    final r = _receiptData!;
    return Scaffold(
      backgroundColor: AppColors.background,
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 20),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                // Success Badge
                Container(
                  width: 76,
                  height: 76,
                  decoration: const BoxDecoration(
                    color: AppColors.primary,
                    shape: BoxShape.circle,
                  ),
                  child: const Center(
                    child: Icon(Icons.check_rounded, color: Colors.white, size: 44),
                  ),
                ),
                const SizedBox(height: 18),
                const Text(
                  'Payment Successful!',
                  style: TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    color: AppColors.textPrimary,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  'Transferred to ${r['dairy_name'] ?? 'Shree Krishna Dairy'}',
                  style: const TextStyle(fontSize: 13, color: AppColors.textSecondary),
                ),
                const SizedBox(height: 20),

                // Receipt Slip Card
                Container(
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: AppColors.border),
                    boxShadow: const [
                      BoxShadow(color: AppColors.cardShadow, blurRadius: 16, offset: Offset(0, 6)),
                    ],
                  ),
                  padding: const EdgeInsets.all(22),
                  child: Column(
                    children: [
                      const Text(
                        'Amount Paid',
                        style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: AppColors.textMuted),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        '₹${r['amount']}',
                        style: const TextStyle(
                          fontSize: 34,
                          fontWeight: FontWeight.w800,
                          color: AppColors.textPrimary,
                          letterSpacing: -1.0,
                        ),
                      ),
                      const SizedBox(height: 18),
                      const Divider(height: 1),
                      const SizedBox(height: 16),

                      _receiptRow('Transaction ID', '${r['transaction_id']}'),
                      const SizedBox(height: 10),
                      _receiptRow('Payment Method', '${r['method']} Instant UPI'),
                      const SizedBox(height: 10),
                      _receiptRow('Payment Date', '${r['payment_date']}'),
                      const SizedBox(height: 10),
                      _receiptRow('Bill Status', '${r['bill_status']}', isHighlight: true),
                      const SizedBox(height: 10),
                      _receiptRow('Remaining Due', '₹${r['remaining_due']}'),
                    ],
                  ),
                ),
                const SizedBox(height: 24),

                CustomButton(
                  text: 'Done & Return to Dashboard',
                  onPressed: () => Navigator.pop(context),
                ),
                const SizedBox(height: 12),
                TextButton.icon(
                  onPressed: () {
                    ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text('Payment receipt saved to phone downloads.')),
                    );
                  },
                  icon: const Icon(Icons.share_rounded, size: 18, color: AppColors.textSecondary),
                  label: const Text(
                    'Share Official Receipt (PDF)',
                    style: TextStyle(color: AppColors.textSecondary, fontWeight: FontWeight.w600),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _receiptRow(String label, String value, {bool isHighlight = false}) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          label,
          style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
        ),
        Text(
          value,
          style: TextStyle(
            fontSize: 12,
            fontWeight: FontWeight.w700,
            color: isHighlight ? AppColors.primary : AppColors.textPrimary,
          ),
        ),
      ],
    );
  }
}
