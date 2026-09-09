class BillModel {
  final int id;
  final String billNumber;
  final String monthYear;
  final double totalLitres;
  final double milkRate;
  final double subtotal;
  final double additionalProductsAmount;
  final double discountAmount;
  final double totalAmount;
  final double paidAmount;
  final double pendingAmount;
  final String status; // paid, pending, partial
  final String dueDate;

  BillModel({
    required this.id,
    required this.billNumber,
    required this.monthYear,
    required this.totalLitres,
    required this.milkRate,
    required this.subtotal,
    required this.additionalProductsAmount,
    required this.discountAmount,
    required this.totalAmount,
    required this.paidAmount,
    required this.pendingAmount,
    required this.status,
    required this.dueDate,
  });

  factory BillModel.fromJson(Map<String, dynamic> json) {
    return BillModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      billNumber: json['bill_number'] ?? 'BILL-2026-0901',
      monthYear: json['month_year'] ?? 'September 2026',
      totalLitres: (json['total_litres'] != null) ? double.tryParse(json['total_litres'].toString()) ?? 58.0 : 58.0,
      milkRate: (json['milk_rate'] != null) ? double.tryParse(json['milk_rate'].toString()) ?? 65.0 : 65.0,
      subtotal: (json['subtotal'] != null) ? double.tryParse(json['subtotal'].toString()) ?? 3770.0 : 3770.0,
      additionalProductsAmount: (json['additional_products_amount'] != null) ? double.tryParse(json['additional_products_amount'].toString()) ?? 210.0 : 210.0,
      discountAmount: (json['discount_amount'] != null) ? double.tryParse(json['discount_amount'].toString()) ?? 100.0 : 100.0,
      totalAmount: (json['total_amount'] != null) ? double.tryParse(json['total_amount'].toString()) ?? 3880.0 : 3880.0,
      paidAmount: (json['paid_amount'] != null) ? double.tryParse(json['paid_amount'].toString()) ?? 2400.0 : 2400.0,
      pendingAmount: (json['pending_amount'] != null) ? double.tryParse(json['pending_amount'].toString()) ?? 1480.0 : 1480.0,
      status: json['status'] ?? 'partial',
      dueDate: json['due_date'] ?? '13 Sep 2026',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'bill_number': billNumber,
      'month_year': monthYear,
      'total_litres': totalLitres,
      'milk_rate': milkRate,
      'subtotal': subtotal,
      'additional_products_amount': additionalProductsAmount,
      'discount_amount': discountAmount,
      'total_amount': totalAmount,
      'paid_amount': paidAmount,
      'pending_amount': pendingAmount,
      'status': status,
      'due_date': dueDate,
    };
  }

  // Mock bills list
  static List<BillModel> mockList() {
    return [
      BillModel(
        id: 1,
        billNumber: 'BILL-2026-0901',
        monthYear: 'September 2026',
        totalLitres: 58.0,
        milkRate: 65.0,
        subtotal: 3770.0,
        additionalProductsAmount: 210.0,
        discountAmount: 100.0,
        totalAmount: 3880.0,
        paidAmount: 2400.0,
        pendingAmount: 1480.0,
        status: 'partial',
        dueDate: '13 Sep 2026',
      ),
      BillModel(
        id: 2,
        billNumber: 'BILL-2026-0801',
        monthYear: 'August 2026',
        totalLitres: 62.0,
        milkRate: 65.0,
        subtotal: 4030.0,
        additionalProductsAmount: 350.0,
        discountAmount: 150.0,
        totalAmount: 4230.0,
        paidAmount: 4230.0,
        pendingAmount: 0.0,
        status: 'paid',
        dueDate: '10 Aug 2026',
      ),
      BillModel(
        id: 3,
        billNumber: 'BILL-2026-0701',
        monthYear: 'July 2026',
        totalLitres: 60.0,
        milkRate: 65.0,
        subtotal: 3900.0,
        additionalProductsAmount: 0.0,
        discountAmount: 0.0,
        totalAmount: 3900.0,
        paidAmount: 3900.0,
        pendingAmount: 0.0,
        status: 'paid',
        dueDate: '10 Jul 2026',
      ),
    ];
  }
}
