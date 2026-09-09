import 'package:flutter/material.dart';
import '../constants/app_colors.dart';

class StatusPill extends StatelessWidget {
  final String status;

  const StatusPill({super.key, required this.status});

  @override
  Widget build(BuildContext context) {
    Color bg;
    Color fg;
    IconData? icon;

    final lower = status.toLowerCase();

    if (lower == 'active' || lower == 'delivered' || lower == 'paid' || lower == 'resolved' || lower == 'approved' || lower == 'completed') {
      bg = const Color(0xFFDCFCE7);
      fg = const Color(0xFF15803D);
      icon = Icons.check_circle_rounded;
    } else if (lower == 'paused' || lower == 'absent' || lower == 'rejected' || lower == 'danger') {
      bg = const Color(0xFFFEE2E2);
      fg = const Color(0xFFB91C1C);
      icon = Icons.cancel_rounded;
    } else if (lower == 'partial' || lower == 'in_progress' || lower == 'extra' || lower == 'open') {
      bg = const Color(0xFFFEF3C7);
      fg = const Color(0xFFB45309);
      icon = Icons.timelapse_rounded;
    } else {
      bg = const Color(0xFFF1F5F9);
      fg = const Color(0xFF475569);
      icon = Icons.info_outline_rounded;
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(8),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          if (icon != null) ...[
            Icon(icon, size: 12, color: fg),
            const SizedBox(width: 4),
          ],
          Text(
            status.toUpperCase(),
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.w700,
              color: fg,
              letterSpacing: 0.4,
            ),
          ),
        ],
      ),
    );
  }
}
