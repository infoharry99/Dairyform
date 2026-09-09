class CustomerRequestModel {
  final int id;
  final String ticketNumber;
  final String customerName;
  final String customerCode;
  final String customerPhone;
  final String subject;
  final String message;
  String status; // open, in_progress, resolved, closed
  String? reply;
  final String createdAt;

  CustomerRequestModel({
    required this.id,
    required this.ticketNumber,
    required this.customerName,
    required this.customerCode,
    required this.customerPhone,
    required this.subject,
    required this.message,
    required this.status,
    this.reply,
    required this.createdAt,
  });

  factory CustomerRequestModel.fromJson(Map<String, dynamic> json) {
    return CustomerRequestModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      ticketNumber: json['ticket_number'] ?? 'REQ-101',
      customerName: json['customer_name'] ?? 'Customer',
      customerCode: json['customer_code'] ?? 'CUST-101',
      customerPhone: json['customer_phone'] ?? '+91 98000 00000',
      subject: json['subject'] ?? 'Schedule Request',
      message: json['message'] ?? '',
      status: json['status'] ?? 'open',
      reply: json['reply'],
      createdAt: json['created_at'] ?? '08 Sep 2026',
    );
  }

  static List<CustomerRequestModel> mockList() {
    return [
      CustomerRequestModel(
        id: 1,
        ticketNumber: 'APP-REQ-901',
        customerName: 'Rajesh Sharma',
        customerCode: 'CUST-101',
        customerPhone: '+91 98930 11223',
        subject: 'Vacation Pause: 12 Sep to 15 Sep',
        message: 'Family going to village for 3 days. Please pause delivery and resume on 16 Sep.',
        status: 'open',
        createdAt: 'Today, 08:30 AM',
      ),
      CustomerRequestModel(
        id: 2,
        ticketNumber: 'APP-REQ-902',
        customerName: 'Pooja Agarwal',
        customerCode: 'CUST-104',
        customerPhone: '+91 97530 12345',
        subject: 'Extra Milk: +2L on 13 Sep (Morning)',
        message: 'Ganesh puja at home, need fresh milk in morning shift.',
        status: 'open',
        createdAt: 'Yesterday, 04:15 PM',
      ),
      CustomerRequestModel(
        id: 3,
        ticketNumber: 'TCK-2026-0901',
        customerName: 'Amitabh Joshi',
        customerCode: 'CUST-103',
        customerPhone: '+91 94250 88990',
        subject: '1 kg Desi Ghee requirement',
        message: 'Please send 1 kg jar with tomorrow morning delivery.',
        status: 'resolved',
        reply: 'Delivered by Suresh and billed to monthly invoice.',
        createdAt: '06 Sep 2026',
      ),
    ];
  }
}
