class MilkRecordModel {
  final int id;
  final String date;
  final String formattedDate;
  final String day;
  final String dayName;
  final String shift; // morning, evening
  final double quantity; // in litres
  final String milkType;
  final double rate;
  final double amount;
  final String status; // delivered, pending, skipped, paused

  MilkRecordModel({
    required this.id,
    required this.date,
    required this.formattedDate,
    required this.day,
    required this.dayName,
    required this.shift,
    required this.quantity,
    required this.milkType,
    required this.rate,
    required this.amount,
    required this.status,
  });

  factory MilkRecordModel.fromJson(Map<String, dynamic> json) {
    return MilkRecordModel(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 0,
      date: json['date'] ?? '',
      formattedDate: json['formatted_date'] ?? json['date'] ?? '',
      day: json['day'] ?? (json['date'] != null && json['date'].toString().length >= 10 ? json['date'].toString().substring(8, 10) : '01'),
      dayName: json['day_name'] ?? 'Mon',
      shift: json['shift'] ?? 'morning',
      quantity: (json['quantity'] != null) ? double.tryParse(json['quantity'].toString()) ?? 2.0 : 2.0,
      milkType: json['milk_type'] ?? 'buffalo',
      rate: (json['rate'] != null) ? double.tryParse(json['rate'].toString()) ?? 65.0 : 65.0,
      amount: (json['amount'] != null) ? double.tryParse(json['amount'].toString()) ?? 130.0 : 130.0,
      status: json['status'] ?? 'delivered',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'date': date,
      'formatted_date': formattedDate,
      'day': day,
      'day_name': dayName,
      'shift': shift,
      'quantity': quantity,
      'milk_type': milkType,
      'rate': rate,
      'amount': amount,
      'status': status,
    };
  }

  // Mock records for Rajesh Sharma
  static List<MilkRecordModel> mockList() {
    return [
      MilkRecordModel(id: 1, date: '2026-09-08', formattedDate: 'Tue, 08 Sep 2026', day: '08', dayName: 'Tue', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
      MilkRecordModel(id: 2, date: '2026-09-07', formattedDate: 'Mon, 07 Sep 2026', day: '07', dayName: 'Mon', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
      MilkRecordModel(id: 3, date: '2026-09-06', formattedDate: 'Sun, 06 Sep 2026', day: '06', dayName: 'Sun', shift: 'morning', quantity: 3.0, milkType: 'buffalo', rate: 65.0, amount: 195.0, status: 'delivered'),
      MilkRecordModel(id: 4, date: '2026-09-05', formattedDate: 'Sat, 05 Sep 2026', day: '05', dayName: 'Sat', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
      MilkRecordModel(id: 5, date: '2026-09-04', formattedDate: 'Fri, 04 Sep 2026', day: '04', dayName: 'Fri', shift: 'morning', quantity: 0.0, milkType: 'buffalo', rate: 65.0, amount: 0.0, status: 'paused'),
      MilkRecordModel(id: 6, date: '2026-09-03', formattedDate: 'Thu, 03 Sep 2026', day: '03', dayName: 'Thu', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
      MilkRecordModel(id: 7, date: '2026-09-02', formattedDate: 'Wed, 02 Sep 2026', day: '02', dayName: 'Wed', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
      MilkRecordModel(id: 8, date: '2026-09-01', formattedDate: 'Tue, 01 Sep 2026', day: '01', dayName: 'Tue', shift: 'morning', quantity: 2.0, milkType: 'buffalo', rate: 65.0, amount: 130.0, status: 'delivered'),
    ];
  }
}
