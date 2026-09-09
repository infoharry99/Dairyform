import 'package:flutter/material.dart';
import '../constants/app_colors.dart';

class ShiftBadge extends StatelessWidget {
  final String text;
  final bool isShift; // true = morning/evening, false = delivered/paused/skipped

  const ShiftBadge({
    super.key,
    required this.text,
    this.isShift = true,
  });

  @override
  Widget build(BuildContext context) {
    Color bg;
    Color fg;
    IconData? icon;

    final lower = text.toLowerCase();

    if (isShift) {
      if (lower.contains('morn')) {
        bg = const Color(0xFFFEF3C7);
        fg = const Color(0xFFB45309);
        icon = Icons.wb_sunny_rounded;
      } else {
        bg = const Color(0xFFEDE9FE);
        fg = const Color(0xFF6D28D9);
        icon = Icons.nightlight_round;
      }
    } else {
      if (lower == 'delivered' || lower == 'paid' || lower == 'approved' || lower == 'resolved') {
        bg = const Color(0xFFDCFCE7);
        fg = const Color(0xFF15803D);
        icon = Icons.check_circle_rounded;
      } else if (lower == 'paused' || lower == 'skipped') {
        bg = const Color(0xFFFEE2E2);
        fg = const Color(0xFFB91C1C);
        icon = Icons.pause_circle_filled_rounded;
      } else if (lower == 'partial') {
        bg = const Color(0xFFFEF9C3);
        fg = const Color(0xFFA16207);
        icon = Icons.pie_chart_rounded;
      } else {
        bg = const Color(0xFFF1F5F9);
        fg = const Color(0xFF475569);
        icon = Icons.info_outline_rounded;
      }
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
            text.toUpperCase(),
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
