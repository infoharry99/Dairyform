import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/customer_request_model.dart';
import '../services/dairy_api_service.dart';
import '../widgets/status_pill.dart';

class CustomerRequestsScreen extends StatefulWidget {
  const CustomerRequestsScreen({super.key});

  @override
  State<CustomerRequestsScreen> createState() => _CustomerRequestsScreenState();
}

class _CustomerRequestsScreenState extends State<CustomerRequestsScreen> {
  bool _isLoading = true;
  List<CustomerRequestModel> _requests = [];

  @override
  void initState() {
    super.initState();
    _fetchRequests();
  }

  Future<void> _fetchRequests() async {
    setState(() => _isLoading = true);
    final list = await DairyApiService().getRequests();
    if (mounted) {
      setState(() {
        _requests = list;
        _isLoading = false;
      });
    }
  }

  Future<void> _handleAction(CustomerRequestModel item, String action) async {
    final replyController = TextEditingController(
      text: action == 'approve' ? 'Approved by Dairy Admin' : 'Cannot fulfill this shift due to stock constraints.',
    );

    final shouldProceed = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: Text('${action == 'approve' ? 'Approve' : 'Reject'} Request?'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('${item.customerName} • ${item.subject}', style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w600)),
            const SizedBox(height: 12),
            const Text('Note to Customer:', style: TextStyle(fontSize: 11, color: AppColors.textMuted)),
            const SizedBox(height: 6),
            TextField(controller: replyController, maxLines: 2, decoration: const InputDecoration(hintText: 'Message to customer')),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context, false), child: const Text('Cancel')),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            style: ElevatedButton.styleFrom(
              backgroundColor: action == 'approve' ? AppColors.primary : AppColors.danger,
            ),
            child: Text('Confirm ${action.toUpperCase()}'),
          ),
        ],
      ),
    );

    if (shouldProceed == true) {
      await DairyApiService().updateRequestStatus(item.id, action, replyController.text.trim());
      await _fetchRequests();

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Request marked as ${action}d.'),
            backgroundColor: action == 'approve' ? AppColors.primary : AppColors.danger,
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: RefreshIndicator(
        onRefresh: _fetchRequests,
        color: AppColors.primary,
        child: SingleChildScrollView(
          physics: const AlwaysScrollableScrollPhysics(),
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    'Customer Action Requests',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: AppColors.primarySurface,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      '${_requests.where((r) => r.status == 'open').length} Open',
                      style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.primaryDark),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 4),
              const Text(
                'Review vacation pause notices, extra milk orders, and customer queries.',
                style: TextStyle(fontSize: 12, color: AppColors.textSecondary),
              ),
              const SizedBox(height: 16),

              if (_isLoading)
                const Center(child: CircularProgressIndicator(color: AppColors.primary))
              else if (_requests.isEmpty)
                const Padding(
                  padding: EdgeInsets.symmetric(vertical: 40),
                  child: Center(child: Text('No active customer requests.', style: TextStyle(color: AppColors.textMuted))),
                )
              else
                ListView.separated(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: _requests.length,
                  separatorBuilder: (_, __) => const SizedBox(height: 12),
                  itemBuilder: (context, index) {
                    final item = _requests[index];
                    final isOpen = item.status == 'open';

                    return Container(
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(16),
                        border: Border.all(color: isOpen ? AppColors.warning.withOpacity(0.4) : AppColors.border),
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Row(
                                children: [
                                  Text(
                                    item.customerName,
                                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                                  ),
                                  const SizedBox(width: 8),
                                  Text(
                                    item.customerCode,
                                    style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.textMuted),
                                  ),
                                ],
                              ),
                              StatusPill(status: item.status),
                            ],
                          ),
                          const SizedBox(height: 6),
                          Text(
                            item.subject,
                            style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w700, color: AppColors.textPrimary),
                          ),
                          const SizedBox(height: 4),
                          Text(
                            item.message,
                            style: const TextStyle(fontSize: 12, color: AppColors.textSecondary, height: 1.3),
                          ),
                          if (item.reply != null && item.reply!.isNotEmpty) ...[
                            const SizedBox(height: 10),
                            Container(
                              padding: const EdgeInsets.all(10),
                              decoration: BoxDecoration(
                                color: AppColors.primarySurface,
                                borderRadius: BorderRadius.circular(8),
                              ),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  const Icon(Icons.reply_rounded, size: 16, color: AppColors.primary),
                                  const SizedBox(width: 6),
                                  Expanded(
                                    child: Text(
                                      'Dairy Response: ${item.reply}',
                                      style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: AppColors.primaryDark),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                          const SizedBox(height: 12),
                          const Divider(height: 1, color: AppColors.divider),
                          const SizedBox(height: 10),

                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(item.createdAt, style: const TextStyle(fontSize: 11, color: AppColors.textMuted)),
                              if (isOpen)
                                Row(
                                  children: [
                                    OutlinedButton(
                                      onPressed: () => _handleAction(item, 'reject'),
                                      style: OutlinedButton.styleFrom(
                                        foregroundColor: AppColors.danger,
                                        side: const BorderSide(color: AppColors.danger),
                                        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
                                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                      ),
                                      child: const Text('Reject', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                    ),
                                    const SizedBox(width: 8),
                                    ElevatedButton(
                                      onPressed: () => _handleAction(item, 'approve'),
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: AppColors.primary,
                                        foregroundColor: Colors.white,
                                        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
                                        elevation: 0,
                                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                      ),
                                      child: const Text('Approve', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                                    ),
                                  ],
                                )
                              else
                                const Row(
                                  children: [
                                    Icon(Icons.check_circle_rounded, size: 14, color: AppColors.primary),
                                    SizedBox(width: 4),
                                    Text('Processed', style: TextStyle(fontSize: 11, fontWeight: FontWeight.w700, color: AppColors.primary)),
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
      ),
    );
  }
}
