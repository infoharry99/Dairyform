import 'dart:convert';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import '../models/dairy_model.dart';
import '../models/customer_summary_model.dart';
import '../models/milk_entry_model.dart';
import '../models/admin_bill_model.dart';
import '../models/customer_request_model.dart';
import '../models/dairy_product_model.dart';

class DairyApiService {
  static final DairyApiService _instance = DairyApiService._internal();
  factory DairyApiService() => _instance;
  DairyApiService._internal();

  String get baseUrl {
    if (kIsWeb) {
      return 'http://localhost:8000/api/dairy';
    }
    try {
      if (Platform.isAndroid) {
        return 'http://10.0.2.2:8000/api/dairy';
      }
    } catch (_) {}
    return 'http://localhost:8000/api/dairy';
  }

  DairyModel currentDairy = DairyModel.mockDemo();
  List<CustomerSummaryModel> cachedCustomers = CustomerSummaryModel.mockList();
  List<MilkEntryModel> cachedRoster = MilkEntryModel.mockRoster();
  List<AdminBillModel> cachedBills = AdminBillModel.mockList();
  List<CustomerRequestModel> cachedRequests = CustomerRequestModel.mockList();
  List<DairyProductModel> cachedProducts = DairyProductModel.mockList();

  // 1. Login
  Future<Map<String, dynamic>> login(String loginIdentifier, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({'login': loginIdentifier, 'password': password}),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['admin'] != null) {
          currentDairy = DairyModel.fromJson(data['admin']);
        }
        return {'success': true, 'message': 'Welcome to MilkFlow Admin Portal'};
      }
    } catch (e) {
      debugPrint('DairyApiService login fallback: $e');
    }

    // Demo / Offline Fallback
    if (loginIdentifier.contains('dairy') || loginIdentifier.contains('98260') || loginIdentifier.isEmpty) {
      currentDairy = DairyModel.mockDemo();
      return {'success': true, 'message': 'Welcome Ramesh Patel (Shree Krishna Dairy)'};
    }

    return {'success': false, 'message': 'Invalid credentials. Demo: dairy@milkflow.demo / password'};
  }

  // 2. Dashboard KPIs
  Future<Map<String, dynamic>> getDashboard() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/dashboard?dairy_id=${currentDairy.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['data'] != null) return data['data'];
      }
    } catch (e) {
      debugPrint('DairyApiService dashboard fallback: $e');
    }

    return {
      'dairy': {
        'id': currentDairy.id,
        'name': currentDairy.name,
        'owner_name': currentDairy.ownerName,
        'phone': currentDairy.phone,
        'plan': currentDairy.planName,
      },
      'kpis': {
        'total_litres_today': 486.0,
        'delivered_litres': 412.0,
        'pending_litres': 74.0,
        'today_revenue': 28450.0,
        'pending_payments': 48200.0,
        'total_customers': 324,
        'active_customers': 312,
        'pending_requests_count': cachedRequests.where((r) => r.status == 'open').length,
      },
      'shifts': {
        'morning': {'status': 'completed', 'delivered_litres': 240.0, 'target_litres': 250.0},
        'evening': {'status': 'in_progress', 'delivered_litres': 172.0, 'target_litres': 236.0},
      }
    };
  }

  // 3. Customers
  Future<List<CustomerSummaryModel>> getCustomers({String? area, String? status, String? search}) async {
    try {
      final uri = Uri.parse('$baseUrl/customers').replace(queryParameters: {
        'dairy_id': currentDairy.id.toString(),
        if (area != null && area != 'All Areas') 'area': area,
        if (status != null && status != 'all') 'status': status,
        if (search != null && search.isNotEmpty) 'search': search,
      });

      final response = await http.get(uri, headers: {'Accept': 'application/json'}).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['customers'] is List) {
          cachedCustomers = (data['customers'] as List)
              .map((c) => CustomerSummaryModel.fromJson(c))
              .toList();
          return cachedCustomers;
        }
      }
    } catch (e) {
      debugPrint('DairyApiService customers fallback: $e');
    }

    var list = List<CustomerSummaryModel>.from(cachedCustomers);
    if (area != null && area != 'All Areas') {
      list = list.where((c) => c.area == area).toList();
    }
    if (status != null && status != 'all') {
      list = list.where((c) => c.status == status).toList();
    }
    if (search != null && search.isNotEmpty) {
      final s = search.toLowerCase();
      list = list.where((c) => c.name.toLowerCase().contains(s) || c.customerCode.toLowerCase().contains(s)).toList();
    }
    return list;
  }

  // 4. Add Customer
  Future<Map<String, dynamic>> addCustomer({
    required String name,
    required String phone,
    required String address,
    required String area,
    required double dailyQuantity,
    required String milkType,
    required String deliveryTime,
    required double ratePerLitre,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/customers'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'dairy_id': currentDairy.id,
          'name': name,
          'phone': phone,
          'address': address,
          'area': area,
          'daily_quantity': dailyQuantity,
          'milk_type': milkType,
          'delivery_time': deliveryTime,
          'rate_per_litre': ratePerLitre,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      }
    } catch (e) {
      debugPrint('DairyApiService addCustomer fallback: $e');
    }

    final newCust = CustomerSummaryModel(
      id: cachedCustomers.length + 1,
      customerCode: 'CUST-${100 + cachedCustomers.length + 1}',
      name: name,
      phone: phone,
      address: address,
      area: area,
      dailyQuantity: dailyQuantity,
      milkType: milkType,
      deliveryTime: deliveryTime,
      ratePerLitre: ratePerLitre,
      status: 'active',
      pendingDue: 0.0,
    );
    cachedCustomers.add(newCust);
    return {'success': true, 'message': 'Customer ${newCust.name} added successfully.'};
  }

  // 5. Toggle Customer Status
  Future<bool> toggleCustomerStatus(int customerId) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/customers/$customerId/toggle-status'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        _updateLocalCustomerStatus(customerId, data['status']);
        return true;
      }
    } catch (e) {
      debugPrint('DairyApiService toggle status fallback: $e');
    }

    // Local toggle
    for (int i = 0; i < cachedCustomers.length; i++) {
      if (cachedCustomers[i].id == customerId) {
        final newSt = cachedCustomers[i].status == 'active' ? 'paused' : 'active';
        _updateLocalCustomerStatus(customerId, newSt);
        break;
      }
    }
    return true;
  }

  void _updateLocalCustomerStatus(int id, String newStatus) {
    for (int i = 0; i < cachedCustomers.length; i++) {
      if (cachedCustomers[i].id == id) {
        final c = cachedCustomers[i];
        cachedCustomers[i] = CustomerSummaryModel(
          id: c.id,
          customerCode: c.customerCode,
          name: c.name,
          phone: c.phone,
          address: c.address,
          area: c.area,
          dailyQuantity: c.dailyQuantity,
          milkType: c.milkType,
          deliveryTime: c.deliveryTime,
          ratePerLitre: c.ratePerLitre,
          status: newStatus,
          pendingDue: c.pendingDue,
        );
        break;
      }
    }
  }

  // 6. Milk Entry Roster
  Future<List<MilkEntryModel>> getMilkEntryRoster(String shift, String date) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/milk-entry?dairy_id=${currentDairy.id}&shift=$shift&date=$date'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['roster'] is List) {
          cachedRoster = (data['roster'] as List)
              .map((r) => MilkEntryModel.fromJson(r))
              .toList();
          return cachedRoster;
        }
      }
    } catch (e) {
      debugPrint('DairyApiService milk roster fallback: $e');
    }
    return cachedRoster;
  }

  // 7. Save Single Milk Entry
  Future<bool> saveMilkEntry({
    required int customerId,
    required String shift,
    required String date,
    required double quantity,
    required String status,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/milk-entry/save'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'dairy_id': currentDairy.id,
          'customer_id': customerId,
          'shift': shift,
          'date': date,
          'quantity': quantity,
          'status': status,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) return true;
    } catch (e) {
      debugPrint('DairyApiService saveMilkEntry fallback: $e');
    }

    // Local update
    for (int i = 0; i < cachedRoster.length; i++) {
      if (cachedRoster[i].customerId == customerId) {
        cachedRoster[i].recordedQuantity = quantity;
        cachedRoster[i].status = status;
        break;
      }
    }
    return true;
  }

  // 8. Batch Mark All Shift Deliveries
  Future<bool> batchMarkDelivered(String shift, String date) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/milk-entry/batch'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'dairy_id': currentDairy.id,
          'shift': shift,
          'date': date,
        }),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) return true;
    } catch (e) {
      debugPrint('DairyApiService batch mark fallback: $e');
    }

    for (var r in cachedRoster) {
      r.recordedQuantity = r.defaultQuantity;
      r.status = 'delivered';
    }
    return true;
  }

  // 9. Bills
  Future<List<AdminBillModel>> getBills() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/bills?dairy_id=${currentDairy.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['bills'] is List) {
          cachedBills = (data['bills'] as List)
              .map((b) => AdminBillModel.fromJson(b))
              .toList();
          return cachedBills;
        }
      }
    } catch (e) {
      debugPrint('DairyApiService bills fallback: $e');
    }
    return cachedBills;
  }

  // 10. Generate Bills
  Future<Map<String, dynamic>> generateBills(String month) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/bills/generate'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({'dairy_id': currentDairy.id, 'month': month}),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) return jsonDecode(response.body);
    } catch (e) {
      debugPrint('DairyApiService generateBills fallback: $e');
    }

    return {'success': true, 'message': 'Successfully generated invoices for ${cachedCustomers.length} active customers.'};
  }

  // 11. Record Payment
  Future<Map<String, dynamic>> recordPayment({
    required int customerId,
    required double amount,
    required String paymentMethod,
    String? notes,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/payments/record'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'dairy_id': currentDairy.id,
          'customer_id': customerId,
          'amount': amount,
          'payment_method': paymentMethod,
          'notes': notes,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) return jsonDecode(response.body);
    } catch (e) {
      debugPrint('DairyApiService record payment fallback: $e');
    }

    // Local update dues
    for (int i = 0; i < cachedCustomers.length; i++) {
      if (cachedCustomers[i].id == customerId) {
        final c = cachedCustomers[i];
        final newDue = (c.pendingDue - amount).clamp(0.0, double.infinity);
        cachedCustomers[i] = CustomerSummaryModel(
          id: c.id,
          customerCode: c.customerCode,
          name: c.name,
          phone: c.phone,
          address: c.address,
          area: c.area,
          dailyQuantity: c.dailyQuantity,
          milkType: c.milkType,
          deliveryTime: c.deliveryTime,
          ratePerLitre: c.ratePerLitre,
          status: c.status,
          pendingDue: newDue,
        );
        break;
      }
    }

    return {
      'success': true,
      'message': 'Payment of ₹${amount.toStringAsFixed(0)} ($paymentMethod) recorded successfully.',
    };
  }

  // 12. Requests
  Future<List<CustomerRequestModel>> getRequests() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/requests?dairy_id=${currentDairy.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['requests'] is List) {
          cachedRequests = (data['requests'] as List)
              .map((r) => CustomerRequestModel.fromJson(r))
              .toList();
          return cachedRequests;
        }
      }
    } catch (e) {
      debugPrint('DairyApiService requests fallback: $e');
    }
    return cachedRequests;
  }

  // 13. Update Request Status
  Future<bool> updateRequestStatus(int id, String action, String reply) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/requests/$id/status'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({'action': action, 'reply': reply}),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) return true;
    } catch (e) {
      debugPrint('DairyApiService update request fallback: $e');
    }

    for (var r in cachedRequests) {
      if (r.id == id) {
        r.status = action == 'approve' ? 'resolved' : 'closed';
        r.reply = reply;
        break;
      }
    }
    return true;
  }

  // 14. Products
  Future<List<DairyProductModel>> getProducts() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/products?dairy_id=${currentDairy.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['products'] is List) {
          cachedProducts = (data['products'] as List)
              .map((p) => DairyProductModel.fromJson(p))
              .toList();
          return cachedProducts;
        }
      }
    } catch (e) {
      debugPrint('DairyApiService products fallback: $e');
    }
    return cachedProducts;
  }

  // 15. Store Product
  Future<bool> storeProduct(DairyProductModel product) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/products'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'dairy_id': currentDairy.id,
          'id': product.id,
          'name': product.name,
          'price': product.price,
          'unit': product.unit,
          'stock': product.stock,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) return true;
    } catch (e) {
      debugPrint('DairyApiService store product fallback: $e');
    }

    for (int i = 0; i < cachedProducts.length; i++) {
      if (cachedProducts[i].id == product.id) {
        cachedProducts[i] = product;
        break;
      }
    }
    return true;
  }
}
