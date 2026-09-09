class SupportTicketModel {
  final int id;
  final String ticketNumber;
  final String subject;
  final String message;
  final String status; // open, in_progress, resolved, closed
  final String? reply;
  final String createdAt;

  SupportTicketModel({
    required this.id,
    required this.ticketNumber,
    required this.subject,
    required this.message,
    required this.status,
    this.reply,
    required this.createdAt,
  });

  factory SupportTicketModel.fromJson(Map<String, dynamic> json) {
    return SupportTicketModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      ticketNumber: json['ticket_number'] ?? 'TCK-2026-101',
      subject: json['subject'] ?? 'Delivery Query',
      message: json['message'] ?? '',
      status: json['status'] ?? 'open',
      reply: json['reply'],
      createdAt: json['created_at'] ?? '08 Sep 2026',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'ticket_number': ticketNumber,
      'subject': subject,
      'message': message,
      'status': status,
      'reply': reply,
      'created_at': createdAt,
    };
  }

  static List<SupportTicketModel> mockList() {
    return [
      SupportTicketModel(
        id: 1,
        ticketNumber: 'TCK-2026-0901',
        subject: 'Morning delivery time inquiry',
        message: 'Can the morning delivery be done before 6:30 AM on weekdays?',
        status: 'resolved',
        reply: 'Hello Rajesh ji, we have informed delivery boy Suresh. He will prioritize your house by 6:20 AM.',
        createdAt: '05 Sep 2026, 09:30 AM',
      ),
      SupportTicketModel(
        id: 2,
        ticketNumber: 'TCK-2026-0902',
        subject: '1 kg Desi Ghee order added to bill',
        message: 'Please send 1 kg Cow Desi Ghee with tomorrow morning delivery.',
        status: 'resolved',
        reply: 'Delivered and added to your monthly bill invoice.',
        createdAt: '03 Sep 2026, 04:15 PM',
      ),
    ];
  }
}
