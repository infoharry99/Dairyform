class CustomerSummaryModel {
  final int id;
  final String customerCode;
  final String name;
  final String phone;
  final String address;
  final String area;
  final double dailyQuantity;
  final String milkType;
  final String deliveryTime;
  final double ratePerLitre;
  final String status;
  final double pendingDue;

  CustomerSummaryModel({
    required this.id,
    required this.customerCode,
    required this.name,
    required this.phone,
    required this.address,
    required this.area,
    required this.dailyQuantity,
    required this.milkType,
    required this.deliveryTime,
    required this.ratePerLitre,
    required this.status,
    required this.pendingDue,
  });

  factory CustomerSummaryModel.fromJson(Map<String, dynamic> json) {
    return CustomerSummaryModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      customerCode: json['customer_code'] ?? 'CUST-101',
      name: json['name'] ?? 'Customer',
      phone: json['phone'] ?? '+91 98000 00000',
      address: json['address'] ?? 'Local Address',
      area: json['area'] ?? 'Vijay Nagar',
      dailyQuantity: (json['daily_quantity'] != null)
          ? double.tryParse(json['daily_quantity'].toString()) ?? 2.0
          : 2.0,
      milkType: json['milk_type'] ?? 'buffalo',
      deliveryTime: json['delivery_time'] ?? 'morning',
      ratePerLitre: (json['rate_per_litre'] != null)
          ? double.tryParse(json['rate_per_litre'].toString()) ?? 65.0
          : 65.0,
      status: json['status'] ?? 'active',
      pendingDue: (json['pending_due'] != null)
          ? double.tryParse(json['pending_due'].toString()) ?? 0.0
          : 0.0,
    );
  }

  static List<CustomerSummaryModel> mockList() {
    return [
      CustomerSummaryModel(id: 1, customerCode: 'CUST-101', name: 'Rajesh Sharma', phone: '+91 98930 11223', address: 'Plot 42, Anand Greens Society', area: 'Vijay Nagar', dailyQuantity: 2.0, milkType: 'buffalo', deliveryTime: 'morning', ratePerLitre: 65.0, status: 'active', pendingDue: 1480.0),
      CustomerSummaryModel(id: 2, customerCode: 'CUST-102', name: 'Sunita Verma', phone: '+91 98270 44556', address: '12-B, Silver Palm Residency', area: 'Vijay Nagar', dailyQuantity: 1.5, milkType: 'cow', deliveryTime: 'morning', ratePerLitre: 55.0, status: 'active', pendingDue: 0.0),
      CustomerSummaryModel(id: 3, customerCode: 'CUST-103', name: 'Amitabh Joshi', phone: '+91 94250 88990', address: '88, Royal Heritage Avenue', area: 'Palasia', dailyQuantity: 3.0, milkType: 'buffalo', deliveryTime: 'both', ratePerLitre: 65.0, status: 'active', pendingDue: 3900.0),
      CustomerSummaryModel(id: 4, customerCode: 'CUST-104', name: 'Pooja Agarwal', phone: '+91 97530 12345', address: 'Flat 402, Sai Vihar Apts', area: 'Scheme 54', dailyQuantity: 2.0, milkType: 'cow', deliveryTime: 'morning', ratePerLitre: 55.0, status: 'paused', pendingDue: 825.0),
      CustomerSummaryModel(id: 5, customerCode: 'CUST-105', name: 'Mahesh Choudhary', phone: '+91 98260 77112', address: '14, Tilak Path, Old City', area: 'Rau', dailyQuantity: 4.0, milkType: 'buffalo', deliveryTime: 'both', ratePerLitre: 65.0, status: 'active', pendingDue: 5200.0),
      CustomerSummaryModel(id: 6, customerCode: 'CUST-106', name: 'Neelam Tiwari', phone: '+91 93000 55443', address: '76, Gulmohar Colony', area: 'Palasia', dailyQuantity: 1.0, milkType: 'cow', deliveryTime: 'morning', ratePerLitre: 55.0, status: 'active', pendingDue: 0.0),
      CustomerSummaryModel(id: 7, customerCode: 'CUST-107', name: 'Dinesh Patel', phone: '+91 98932 66778', address: '201, Krishna Heights', area: 'Scheme 54', dailyQuantity: 2.5, milkType: 'buffalo', deliveryTime: 'evening', ratePerLitre: 65.0, status: 'active', pendingDue: 2150.0),
      CustomerSummaryModel(id: 8, customerCode: 'CUST-108', name: 'Kavita Rathore', phone: '+91 97130 99887', address: '33, Shanti Niketan', area: 'Vijay Nagar', dailyQuantity: 2.0, milkType: 'buffalo', deliveryTime: 'morning', ratePerLitre: 65.0, status: 'active', pendingDue: 0.0),
    ];
  }
}
