class AdminBillModel {
  final int id;
  final String billNumber;
  final String customerName;
  final String customerCode;
  final String monthYear;
  final double totalLitres;
  final double totalAmount;
  final double paidAmount;
  final double pendingAmount;
  final String status;
  final String dueDate;

  AdminBillModel({
    required this.id,
    required this.billNumber,
    required this.customerName,
    required this.customerCode,
    required this.monthYear,
    required this.totalLitres,
    required this.totalAmount,
    required this.paidAmount,
    required this.pendingAmount,
    required this.status,
    required this.dueDate,
  });

  factory AdminBillModel.fromJson(Map<String, dynamic> json) {
    return AdminBillModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      billNumber: json['bill_number'] ?? 'BILL-2026-001',
      customerName: json['customer_name'] ?? 'Customer',
      customerCode: json['customer_code'] ?? 'CUST-101',
      monthYear: json['month_year'] ?? 'September 2026',
      totalLitres: (json['total_litres'] != null)
          ? double.tryParse(json['total_litres'].toString()) ?? 58.0
          : 58.0,
      totalAmount: (json['total_amount'] != null)
          ? double.tryParse(json['total_amount'].toString()) ?? 3880.0
          : 3880.0,
      paidAmount: (json['paid_amount'] != null)
          ? double.tryParse(json['paid_amount'].toString()) ?? 2400.0
          : 2400.0,
      pendingAmount: (json['pending_amount'] != null)
          ? double.tryParse(json['pending_amount'].toString()) ?? 1480.0
          : 1480.0,
      status: json['status'] ?? 'partial',
      dueDate: json['due_date'] ?? '15 Sep 2026',
    );
  }

  static List<AdminBillModel> mockList() {
    return [
      AdminBillModel(id: 1, billNumber: 'BILL-2026-0901', customerName: 'Rajesh Sharma', customerCode: 'CUST-101', monthYear: 'September 2026', totalLitres: 58.0, totalAmount: 3880.0, paidAmount: 2400.0, pendingAmount: 1480.0, status: 'partial', dueDate: '15 Sep 2026'),
      AdminBillModel(id: 2, billNumber: 'BILL-2026-0902', customerName: 'Amitabh Joshi', customerCode: 'CUST-103', monthYear: 'September 2026', totalLitres: 87.0, totalAmount: 5655.0, paidAmount: 1755.0, pendingAmount: 3900.0, status: 'partial', dueDate: '15 Sep 2026'),
      AdminBillModel(id: 3, billNumber: 'BILL-2026-0903', customerName: 'Sunita Verma', customerCode: 'CUST-102', monthYear: 'September 2026', totalLitres: 43.5, totalAmount: 2392.0, paidAmount: 2392.0, pendingAmount: 0.0, status: 'paid', dueDate: '15 Sep 2026'),
      AdminBillModel(id: 4, billNumber: 'BILL-2026-0904', customerName: 'Mahesh Choudhary', customerCode: 'CUST-105', monthYear: 'September 2026', totalLitres: 116.0, totalAmount: 7540.0, paidAmount: 2340.0, pendingAmount: 5200.0, status: 'partial', dueDate: '15 Sep 2026'),
      AdminBillModel(id: 5, billNumber: 'BILL-2026-0905', customerName: 'Dinesh Patel', customerCode: 'CUST-107', monthYear: 'September 2026', totalLitres: 72.5, totalAmount: 4712.0, paidAmount: 2562.0, pendingAmount: 2150.0, status: 'partial', dueDate: '15 Sep 2026'),
    ];
  }
}
