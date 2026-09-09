import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/customer_summary_model.dart';
import '../services/dairy_api_service.dart';
import '../widgets/primary_button.dart';
import '../widgets/status_pill.dart';

class CustomerManagementScreen extends StatefulWidget {
  const CustomerManagementScreen({super.key});

  @override
  State<CustomerManagementScreen> createState() => _CustomerManagementScreenState();
}

class _CustomerManagementScreenState extends State<CustomerManagementScreen> {
  bool _isLoading = true;
  List<CustomerSummaryModel> _customers = [];
  String _selectedArea = 'All Areas';
  String _searchQuery = '';
  final _searchController = TextEditingController();

  final List<String> _areas = ['All Areas', 'Vijay Nagar', 'Palasia', 'Scheme 54', 'Rau'];

  @override
  void initState() {
    super.initState();
    _fetchCustomers();
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  Future<void> _fetchCustomers() async {
    setState(() => _isLoading = true);
    final list = await DairyApiService().getCustomers(
      area: _selectedArea,
      search: _searchQuery,
    );
    if (mounted) {
      setState(() {
        _customers = list;
        _isLoading = false;
      });
    }
  }

  Future<void> _toggleStatus(CustomerSummaryModel customer) async {
    await DairyApiService().toggleCustomerStatus(customer.id);
    await _fetchCustomers();
  }

  void _showAddCustomerModal() {
    final nameController = TextEditingController();
    final phoneController = TextEditingController();
    final addressController = TextEditingController();
    String area = 'Vijay Nagar';
    double quota = 2.0;
    String milkType = 'buffalo';
    double rate = 65.0;

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
                      const Text('Add New Route Customer', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w800, color: AppColors.textPrimary)),
                      const SizedBox(height: 4),
                      const Text('Enroll customer to milk delivery schedule', style: TextStyle(fontSize: 12, color: AppColors.textSecondary)),
                      const SizedBox(height: 18),

                      const Text('Customer Full Name', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      TextField(controller: nameController, decoration: const InputDecoration(hintText: 'e.g. Ramesh Chandra')),
                      const SizedBox(height: 12),

                      const Text('Mobile Number', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      TextField(controller: phoneController, keyboardType: TextInputType.phone, decoration: const InputDecoration(hintText: '98260XXXXX')),
                      const SizedBox(height: 12),

                      const Text('Delivery Address & House No', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                      const SizedBox(height: 6),
                      TextField(controller: addressController, decoration: const InputDecoration(hintText: 'Plot 12, Sector B')),
                      const SizedBox(height: 12),

                      Row(
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text('Route Area Zone', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                const SizedBox(height: 6),
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 12),
                                  decoration: BoxDecoration(border: Border.all(color: AppColors.border), borderRadius: BorderRadius.circular(12)),
                                  child: DropdownButtonHideUnderline(
                                    child: DropdownButton<String>(
                                      value: area,
                                      isExpanded: true,
                                      items: ['Vijay Nagar', 'Palasia', 'Scheme 54', 'Rau'].map((a) => DropdownMenuItem(value: a, child: Text(a, style: const TextStyle(fontSize: 13)))).toList(),
                                      onChanged: (val) => setModalState(() => area = val!),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text('Daily Quota (L)', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                const SizedBox(height: 6),
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 12),
                                  decoration: BoxDecoration(border: Border.all(color: AppColors.border), borderRadius: BorderRadius.circular(12)),
                                  child: DropdownButtonHideUnderline(
                                    child: DropdownButton<double>(
                                      value: quota,
                                      isExpanded: true,
                                      items: [1.0, 1.5, 2.0, 2.5, 3.0, 4.0, 5.0].map((q) => DropdownMenuItem(value: q, child: Text('$q L', style: const TextStyle(fontSize: 13)))).toList(),
                                      onChanged: (val) => setModalState(() => quota = val!),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 14),

                      Row(
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text('Milk Type', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                const SizedBox(height: 6),
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 12),
                                  decoration: BoxDecoration(border: Border.all(color: AppColors.border), borderRadius: BorderRadius.circular(12)),
                                  child: DropdownButtonHideUnderline(
                                    child: DropdownButton<String>(
                                      value: milkType,
                                      isExpanded: true,
                                      items: const [
                                        DropdownMenuItem(value: 'buffalo', child: Text('Buffalo Milk', style: TextStyle(fontSize: 13))),
                                        DropdownMenuItem(value: 'cow', child: Text('Cow Milk', style: TextStyle(fontSize: 13))),
                                      ],
                                      onChanged: (val) {
                                        setModalState(() {
                                          milkType = val!;
                                          rate = (val == 'buffalo') ? 65.0 : 55.0;
                                        });
                                      },
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text('Rate / Litre (₹)', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                const SizedBox(height: 6),
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 14),
                                  decoration: BoxDecoration(color: AppColors.background, border: Border.all(color: AppColors.border), borderRadius: BorderRadius.circular(12)),
                                  child: Text('₹${rate.toStringAsFixed(0)} / L', style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: AppColors.textPrimary)),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 24),

                      PrimaryButton(
                        text: 'Save & Enroll Customer',
                        icon: Icons.person_add_alt_1_rounded,
                        onPressed: () async {
                          if (nameController.text.trim().isEmpty) return;

                          await DairyApiService().addCustomer(
                            name: nameController.text.trim(),
                            phone: phoneController.text.trim().isNotEmpty ? phoneController.text.trim() : '+91 98000 11223',
                            address: addressController.text.trim().isNotEmpty ? addressController.text.trim() : 'Local Colony',
                            area: area,
                            dailyQuantity: quota,
                            milkType: milkType,
                            deliveryTime: 'morning',
                            ratePerLitre: rate,
                          );

                          if (mounted) {
                            Navigator.pop(context);
                            _fetchCustomers();
                            ScaffoldMessenger.of(context).showSnackBar(
                              const SnackBar(content: Text('New customer successfully added to delivery roster!'), backgroundColor: AppColors.primary),
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          // Search & Filter Header
          Container(
            color: Colors.white,
            padding: const EdgeInsets.all(16),
            child: Column(
              children: [
                Row(
                  children: [
                    Expanded(
                      child: TextField(
                        controller: _searchController,
                        onChanged: (val) {
                          _searchQuery = val;
                          _fetchCustomers();
                        },
                        decoration: InputDecoration(
                          hintText: 'Search customer name or code...',
                          prefixIcon: const Icon(Icons.search_rounded, size: 20, color: AppColors.textMuted),
                          suffixIcon: _searchQuery.isNotEmpty
                              ? IconButton(
                                  icon: const Icon(Icons.clear, size: 18),
                                  onPressed: () {
                                    _searchController.clear();
                                    _searchQuery = '';
                                    _fetchCustomers();
                                  },
                                )
                              : null,
                          contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
                        ),
                      ),
                    ),
                    const SizedBox(width: 10),
                    ElevatedButton(
                      onPressed: _showAddCustomerModal,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                        elevation: 0,
                      ),
                      child: const Row(
                        children: [
                          Icon(Icons.add, size: 18),
                          SizedBox(width: 4),
                          Text('Add', style: TextStyle(fontWeight: FontWeight.w700)),
                        ],
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),

                // Area Chips Filter
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: _areas.map((a) {
                      final isSel = _selectedArea == a;
                      return GestureDetector(
                        onTap: () {
                          setState(() => _selectedArea = a);
                          _fetchCustomers();
                        },
                        child: Container(
                          margin: const EdgeInsets.only(right: 8),
                          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                          decoration: BoxDecoration(
                            color: isSel ? AppColors.primary : Colors.white,
                            borderRadius: BorderRadius.circular(20),
                            border: Border.all(color: isSel ? AppColors.primary : AppColors.border),
                          ),
                          child: Text(
                            a,
                            style: TextStyle(
                              fontSize: 12,
                              fontWeight: isSel ? FontWeight.w700 : FontWeight.w500,
                              color: isSel ? Colors.white : AppColors.textSecondary,
                            ),
                          ),
                        ),
                      );
                    }).toList(),
                  ),
                ),
              ],
            ),
          ),
          const Divider(height: 1, color: AppColors.border),

          // Customers List
          Expanded(
            child: _isLoading
                ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
                : _customers.isEmpty
                    ? const Center(child: Text('No customers found', style: TextStyle(color: AppColors.textMuted)))
                    : ListView.separated(
                        padding: const EdgeInsets.all(16),
                        itemCount: _customers.length,
                        separatorBuilder: (_, __) => const SizedBox(height: 12),
                        itemBuilder: (context, index) {
                          final c = _customers[index];
                          final isPaused = c.status == 'paused';

                          return Container(
                            padding: const EdgeInsets.all(16),
                            decoration: BoxDecoration(
                              color: Colors.white,
                              borderRadius: BorderRadius.circular(16),
                              border: Border.all(color: isPaused ? AppColors.danger.withOpacity(0.3) : AppColors.border),
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Row(
                                      children: [
                                        Container(
                                          width: 38,
                                          height: 38,
                                          decoration: BoxDecoration(
                                            color: isPaused ? AppColors.dangerSurface : AppColors.primarySurface,
                                            shape: BoxShape.circle,
                                          ),
                                          child: Center(
                                            child: Text(
                                              c.name.substring(0, 1),
                                              style: TextStyle(
                                                fontSize: 16,
                                                fontWeight: FontWeight.w800,
                                                color: isPaused ? AppColors.danger : AppColors.primary,
                                              ),
                                            ),
                                          ),
                                        ),
                                        const SizedBox(width: 12),
                                        Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Text(
                                              c.name,
                                              style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                                            ),
                                            Text(
                                              '${c.customerCode} • ${c.phone}',
                                              style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                            ),
                                          ],
                                        ),
                                      ],
                                    ),
                                    StatusPill(status: c.status),
                                  ],
                                ),
                                const SizedBox(height: 12),
                                const Divider(height: 1, color: AppColors.divider),
                                const SizedBox(height: 10),

                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          '${c.dailyQuantity.toStringAsFixed(1)}L ${c.milkType.toUpperCase()} (@₹${c.ratePerLitre.toStringAsFixed(0)}/L)',
                                          style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                                        ),
                                        const SizedBox(height: 2),
                                        Text(
                                          '${c.area} • ${c.address}',
                                          style: const TextStyle(fontSize: 11, color: AppColors.textSecondary),
                                          maxLines: 1,
                                          overflow: TextOverflow.ellipsis,
                                        ),
                                      ],
                                    ),
                                    Column(
                                      crossAxisAlignment: CrossAxisAlignment.end,
                                      children: [
                                        Text(
                                          c.pendingDue > 0 ? '₹${c.pendingDue.toStringAsFixed(0)}' : 'Clear',
                                          style: TextStyle(
                                            fontSize: 15,
                                            fontWeight: FontWeight.w800,
                                            color: c.pendingDue > 0 ? AppColors.danger : AppColors.primary,
                                          ),
                                        ),
                                        Text(
                                          c.pendingDue > 0 ? 'Pending Due' : 'Zero Balance',
                                          style: const TextStyle(fontSize: 10, color: AppColors.textMuted),
                                        ),
                                      ],
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 12),

                                // Action Buttons: Call, WhatsApp, Toggle Status
                                Row(
                                  children: [
                                    Expanded(
                                      child: OutlinedButton.icon(
                                        onPressed: () {
                                          ScaffoldMessenger.of(context).showSnackBar(
                                            SnackBar(content: Text('Calling ${c.name}: ${c.phone}')),
                                          );
                                        },
                                        icon: const Icon(Icons.phone_rounded, size: 14),
                                        label: const Text('Call', style: TextStyle(fontSize: 11, fontWeight: FontWeight.w700)),
                                        style: OutlinedButton.styleFrom(
                                          foregroundColor: AppColors.primary,
                                          side: const BorderSide(color: AppColors.border),
                                          padding: const EdgeInsets.symmetric(vertical: 6),
                                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                        ),
                                      ),
                                    ),
                                    const SizedBox(width: 8),
                                    Expanded(
                                      child: OutlinedButton.icon(
                                        onPressed: () {
                                          ScaffoldMessenger.of(context).showSnackBar(
                                            SnackBar(content: Text('Opening WhatsApp chat with ${c.name}')),
                                          );
                                        },
                                        icon: const Icon(Icons.chat_rounded, size: 14, color: Color(0xFF25D366)),
                                        label: const Text('WhatsApp', style: TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: Color(0xFF15803D))),
                                        style: OutlinedButton.styleFrom(
                                          side: const BorderSide(color: AppColors.border),
                                          padding: const EdgeInsets.symmetric(vertical: 6),
                                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                        ),
                                      ),
                                    ),
                                    const SizedBox(width: 8),
                                    Expanded(
                                      child: ElevatedButton(
                                        onPressed: () => _toggleStatus(c),
                                        style: ElevatedButton.styleFrom(
                                          backgroundColor: isPaused ? AppColors.primary : const Color(0xFFFEF2F2),
                                          foregroundColor: isPaused ? Colors.white : AppColors.danger,
                                          padding: const EdgeInsets.symmetric(vertical: 6),
                                          elevation: 0,
                                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                        ),
                                        child: Text(
                                          isPaused ? 'Resume' : 'Pause',
                                          style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w700),
                                        ),
                                      ),
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
}
