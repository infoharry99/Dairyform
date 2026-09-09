class CustomerModel {
  final int id;
  final String customerCode;
  final String name;
  final String phone;
  final String email;
  final String address;
  final String area;
  final double dailyQuantity;
  final String milkType;
  final String deliveryTime;
  final double ratePerLitre;
  final String status;
  final String dairyName;
  final String dairyPhone;

  CustomerModel({
    required this.id,
    required this.customerCode,
    required this.name,
    required this.phone,
    required this.email,
    required this.address,
    required this.area,
    required this.dailyQuantity,
    required this.milkType,
    required this.deliveryTime,
    required this.ratePerLitre,
    required this.status,
    required this.dairyName,
    required this.dairyPhone,
  });

  factory CustomerModel.fromJson(Map<String, dynamic> json) {
    return CustomerModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      customerCode: json['customer_code'] ?? 'CUST-101',
      name: json['name'] ?? 'Rajesh Sharma',
      phone: json['phone'] ?? '+91 98930 11223',
      email: json['email'] ?? 'rajesh@example.com',
      address: json['address'] ?? '42, Shanti Nagar, Near Krishna Temple',
      area: json['area'] ?? 'West Zone, Anand',
      dailyQuantity: (json['daily_quantity'] != null)
          ? double.tryParse(json['daily_quantity'].toString()) ?? 2.0
          : 2.0,
      milkType: json['milk_type'] ?? 'buffalo',
      deliveryTime: json['delivery_time'] ?? 'morning',
      ratePerLitre: (json['rate_per_litre'] != null)
          ? double.tryParse(json['rate_per_litre'].toString()) ?? 65.0
          : 65.0,
      status: json['status'] ?? 'active',
      dairyName: json['dairy_name'] ?? 'Shree Krishna Dairy',
      dairyPhone: json['dairy_phone'] ?? '+91 98260 12345',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'customer_code': customerCode,
      'name': name,
      'phone': phone,
      'email': email,
      'address': address,
      'area': area,
      'daily_quantity': dailyQuantity,
      'milk_type': milkType,
      'delivery_time': deliveryTime,
      'rate_per_litre': ratePerLitre,
      'status': status,
      'dairy_name': dairyName,
      'dairy_phone': dairyPhone,
    };
  }

  // Factory for default/mock demo user Rajesh Sharma
  factory CustomerModel.mockDemo() {
    return CustomerModel(
      id: 1,
      customerCode: 'CUST-101',
      name: 'Rajesh Sharma',
      phone: '+91 98930 11223',
      email: 'customer@milkflow.demo',
      address: 'Plot 42, Anand Greens Society, Anand Road',
      area: 'Zone A - Anand City',
      dailyQuantity: 2.0,
      milkType: 'Buffalo Milk (Fresh A2)',
      deliveryTime: 'Morning (06:30 AM - 07:00 AM)',
      ratePerLitre: 65.0,
      status: 'active',
      dairyName: 'Shree Krishna Dairy Farm',
      dairyPhone: '+91 98260 12345',
    );
  }
}
