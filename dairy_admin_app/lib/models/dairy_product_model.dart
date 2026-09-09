class DairyProductModel {
  final int id;
  final String name;
  double price;
  final String unit;
  double stock;
  final String status;

  DairyProductModel({
    required this.id,
    required this.name,
    required this.price,
    required this.unit,
    required this.stock,
    required this.status,
  });

  factory DairyProductModel.fromJson(Map<String, dynamic> json) {
    return DairyProductModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 1,
      name: json['name'] ?? 'Product',
      price: (json['price'] != null)
          ? double.tryParse(json['price'].toString()) ?? 65.0
          : 65.0,
      unit: json['unit'] ?? 'Litre',
      stock: (json['stock'] != null)
          ? double.tryParse(json['stock'].toString()) ?? 100.0
          : 100.0,
      status: json['status'] ?? 'active',
    );
  }

  static List<DairyProductModel> mockList() {
    return [
      DairyProductModel(id: 1, name: 'Fresh Buffalo Milk (A2 Pure)', price: 65.0, unit: 'Litre', stock: 320.0, status: 'active'),
      DairyProductModel(id: 2, name: 'Pure Cow Milk (Desi Gir)', price: 55.0, unit: 'Litre', stock: 180.0, status: 'active'),
      DairyProductModel(id: 3, name: 'Traditional Desi Ghee (Bilona)', price: 650.0, unit: '1 Kg Jar', stock: 45.0, status: 'active'),
      DairyProductModel(id: 4, name: 'Fresh Malai Paneer', price: 380.0, unit: 'Kg', stock: 35.0, status: 'active'),
      DairyProductModel(id: 5, name: 'Organic Fresh Dahi (Curd)', price: 80.0, unit: '1 Kg Matka', stock: 60.0, status: 'active'),
      DairyProductModel(id: 6, name: 'White Makhan (Butter)', price: 420.0, unit: 'Kg', stock: 20.0, status: 'active'),
    ];
  }
}
