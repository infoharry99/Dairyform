class MilkEntryModel {
  final int customerId;
  final String customerCode;
  final String name;
  final String area;
  final double defaultQuantity;
  double recordedQuantity;
  final String milkType;
  final double rate;
  String status; // delivered, absent, extra, paused
  final int? recordId;

  MilkEntryModel({
    required this.customerId,
    required this.customerCode,
    required this.name,
    required this.area,
    required this.defaultQuantity,
    required this.recordedQuantity,
    required this.milkType,
    required this.rate,
    required this.status,
    this.recordId,
  });

  factory MilkEntryModel.fromJson(Map<String, dynamic> json) {
    return MilkEntryModel(
      customerId: json['customer_id'] is int ? json['customer_id'] : int.tryParse(json['customer_id'].toString()) ?? 1,
      customerCode: json['customer_code'] ?? 'CUST-101',
      name: json['name'] ?? 'Customer',
      area: json['area'] ?? 'Vijay Nagar',
      defaultQuantity: (json['default_quantity'] != null)
          ? double.tryParse(json['default_quantity'].toString()) ?? 2.0
          : 2.0,
      recordedQuantity: (json['recorded_quantity'] != null)
          ? double.tryParse(json['recorded_quantity'].toString()) ?? 2.0
          : 2.0,
      milkType: json['milk_type'] ?? 'buffalo',
      rate: (json['rate'] != null)
          ? double.tryParse(json['rate'].toString()) ?? 65.0
          : 65.0,
      status: json['status'] ?? 'delivered',
      recordId: json['record_id'],
    );
  }

  static List<MilkEntryModel> mockRoster() {
    return [
      MilkEntryModel(customerId: 1, customerCode: 'CUST-101', name: 'Rajesh Sharma', area: 'Vijay Nagar', defaultQuantity: 2.0, recordedQuantity: 2.0, milkType: 'buffalo', rate: 65.0, status: 'delivered'),
      MilkEntryModel(customerId: 2, customerCode: 'CUST-102', name: 'Sunita Verma', area: 'Vijay Nagar', defaultQuantity: 1.5, recordedQuantity: 1.5, milkType: 'cow', rate: 55.0, status: 'delivered'),
      MilkEntryModel(customerId: 3, customerCode: 'CUST-103', name: 'Amitabh Joshi', area: 'Palasia', defaultQuantity: 3.0, recordedQuantity: 3.0, milkType: 'buffalo', rate: 65.0, status: 'delivered'),
      MilkEntryModel(customerId: 4, customerCode: 'CUST-104', name: 'Pooja Agarwal', area: 'Scheme 54', defaultQuantity: 2.0, recordedQuantity: 0.0, milkType: 'cow', rate: 55.0, status: 'absent'),
      MilkEntryModel(customerId: 5, customerCode: 'CUST-105', name: 'Mahesh Choudhary', area: 'Rau', defaultQuantity: 4.0, recordedQuantity: 4.0, milkType: 'buffalo', rate: 65.0, status: 'delivered'),
      MilkEntryModel(customerId: 6, customerCode: 'CUST-106', name: 'Neelam Tiwari', area: 'Palasia', defaultQuantity: 1.0, recordedQuantity: 2.0, milkType: 'cow', rate: 55.0, status: 'extra'),
      MilkEntryModel(customerId: 7, customerCode: 'CUST-107', name: 'Dinesh Patel', area: 'Scheme 54', defaultQuantity: 2.5, recordedQuantity: 2.5, milkType: 'buffalo', rate: 65.0, status: 'delivered'),
      MilkEntryModel(customerId: 8, customerCode: 'CUST-108', name: 'Kavita Rathore', area: 'Vijay Nagar', defaultQuantity: 2.0, recordedQuantity: 2.0, milkType: 'buffalo', rate: 65.0, status: 'delivered'),
    ];
  }
}
