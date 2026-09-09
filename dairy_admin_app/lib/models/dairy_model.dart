class DairyModel {
  final int id;
  final String name;
  final String ownerName;
  final String phone;
  final String email;
  final String city;
  final String state;
  final String planName;
  final String status;

  DairyModel({
    required this.id,
    required this.name,
    required this.ownerName,
    required this.phone,
    required this.email,
    required this.city,
    required this.state,
    required this.planName,
    required this.status,
  });

  factory DairyModel.fromJson(Map<String, dynamic> json) {
    return DairyModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      name: json['name'] ?? json['dairy_name'] ?? 'Shree Krishna Dairy Farm',
      ownerName: json['owner_name'] ?? 'Ramesh Patel',
      phone: json['phone'] ?? '+91 98260 12345',
      email: json['email'] ?? 'dairy@milkflow.demo',
      city: json['city'] ?? 'Anand',
      state: json['state'] ?? 'Gujarat',
      planName: json['plan_name'] ?? json['plan'] ?? 'Professional Plan',
      status: json['status'] ?? json['subscription_status'] ?? 'active',
    );
  }

  factory DairyModel.mockDemo() {
    return DairyModel(
      id: 1,
      name: 'Shree Krishna Dairy Farm',
      ownerName: 'Ramesh Patel',
      phone: '+91 98260 12345',
      email: 'dairy@milkflow.demo',
      city: 'Anand',
      state: 'Gujarat',
      planName: 'Professional Plan (₹999/mo)',
      status: 'active',
    );
  }
}
