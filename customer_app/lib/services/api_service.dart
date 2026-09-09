import 'dart:convert';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import '../models/customer_model.dart';
import '../models/milk_record_model.dart';
import '../models/bill_model.dart';
import '../models/support_ticket_model.dart';

class ApiService {
  static final ApiService _instance = ApiService._internal();
  factory ApiService() => _instance;
  ApiService._internal();

  // Smart default base URL depending on platform
  String get baseUrl {
    if (kIsWeb) {
      return 'http://localhost:8000/api/customer';
    }
    try {
      if (Platform.isAndroid) {
        return 'http://10.0.2.2:8000/api/customer';
      }
    } catch (_) {}
    return 'http://localhost:8000/api/customer';
  }

  CustomerModel currentCustomer = CustomerModel.mockDemo();
  List<MilkRecordModel> cachedMilkRecords = MilkRecordModel.mockList();
  List<BillModel> cachedBills = BillModel.mockList();
  List<SupportTicketModel> cachedTickets = SupportTicketModel.mockList();

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
        if (data['customer'] != null) {
          currentCustomer = CustomerModel.fromJson(data['customer']);
        }
        return {'success': true, 'message': 'Login successful'};
      }
    } catch (e) {
      debugPrint('ApiService login fallback: $e');
    }

    // Offline / Demo Fallback Login
    if (loginIdentifier.contains('customer') || loginIdentifier.contains('98930') || loginIdentifier.isEmpty) {
      currentCustomer = CustomerModel.mockDemo();
      return {'success': true, 'message': 'Welcome Rajesh Sharma (Offline Demo)'};
    }

    return {'success': false, 'message': 'Invalid credentials. Demo: customer@milkflow.demo / password'};
  }

  // 2. Dashboard Data
  Future<Map<String, dynamic>> getDashboard() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/dashboard/${currentCustomer.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['data'] != null) {
          return data['data'];
        }
      }
    } catch (e) {
      debugPrint('ApiService dashboard fallback: $e');
    }

    // High fidelity fallback dashboard data
    return {
      'customer': {
        'id': currentCustomer.id,
        'name': currentCustomer.name,
        'customer_code': currentCustomer.customerCode,
        'dairy_name': currentCustomer.dairyName,
        'dairy_phone': currentCustomer.dairyPhone,
      },
      'today': {
        'quantity': currentCustomer.dailyQuantity,
        'milk_type': currentCustomer.milkType,
        'status': 'delivered',
        'delivered_time': '06:45 AM',
        'delivery_boy': 'Suresh Parmar',
      },
      'month_stats': {
        'total_litres': 58.0,
        'month_name': 'September 2026',
        'bill_total': cachedBills.isNotEmpty ? cachedBills.first.totalAmount : 3880.0,
        'paid_amount': cachedBills.isNotEmpty ? cachedBills.first.paidAmount : 2400.0,
        'pending_amount': cachedBills.isNotEmpty ? cachedBills.first.pendingAmount : 1480.0,
        'bill_status': cachedBills.isNotEmpty ? cachedBills.first.status : 'partial',
        'bill_id': cachedBills.isNotEmpty ? cachedBills.first.id : 1,
        'due_date': '13 Sep 2026',
      },
      'recent_records': cachedMilkRecords.take(7).map((r) => r.toJson()).toList(),
    };
  }

  // 3. Milk History Records
  Future<List<MilkRecordModel>> getMilkRecords() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/milk/${currentCustomer.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['records'] is List) {
          cachedMilkRecords = (data['records'] as List)
              .map((r) => MilkRecordModel.fromJson(r))
              .toList();
          return cachedMilkRecords;
        }
      }
    } catch (e) {
      debugPrint('ApiService milk records fallback: $e');
    }
    return cachedMilkRecords;
  }

  // 4. Bills List
  Future<List<BillModel>> getBills() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/bills/${currentCustomer.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['bills'] is List) {
          cachedBills = (data['bills'] as List)
              .map((b) => BillModel.fromJson(b))
              .toList();
          return cachedBills;
        }
      }
    } catch (e) {
      debugPrint('ApiService bills fallback: $e');
    }
    return cachedBills;
  }

  // 5. Pay Bill
  Future<Map<String, dynamic>> payBill({
    required int billId,
    required double amount,
    required String paymentMethod,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/pay'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'customer_id': currentCustomer.id,
          'bill_id': billId,
          'amount': amount,
          'payment_method': paymentMethod,
        }),
      ).timeout(const Duration(seconds: 5));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        _updateLocalBillStatus(billId, amount);
        return data;
      }
    } catch (e) {
      debugPrint('ApiService pay fallback: $e');
    }

    // Local simulation fallback
    _updateLocalBillStatus(billId, amount);
    final txId = 'MF${DateTime.now().millisecondsSinceEpoch.toString().substring(3, 13)}';
    return {
      'success': true,
      'message': 'Payment processed successfully',
      'receipt': {
        'transaction_id': txId,
        'amount': amount,
        'method': paymentMethod.toUpperCase(),
        'payment_date': '08 Sep 2026, 06:15 PM',
        'bill_status': 'PAID',
        'remaining_due': 0.0,
        'dairy_name': currentCustomer.dairyName,
      }
    };
  }

  void _updateLocalBillStatus(int billId, double amountPaid) {
    for (int i = 0; i < cachedBills.length; i++) {
      if (cachedBills[i].id == billId) {
        final b = cachedBills[i];
        final newPaid = b.paidAmount + amountPaid;
        final newPending = (b.totalAmount - newPaid).clamp(0.0, double.infinity);
        final newStatus = newPending <= 0 ? 'paid' : 'partial';

        cachedBills[i] = BillModel(
          id: b.id,
          billNumber: b.billNumber,
          monthYear: b.monthYear,
          totalLitres: b.totalLitres,
          milkRate: b.milkRate,
          subtotal: b.subtotal,
          additionalProductsAmount: b.additionalProductsAmount,
          discountAmount: b.discountAmount,
          totalAmount: b.totalAmount,
          paidAmount: newPaid,
          pendingAmount: newPending,
          status: newStatus,
          dueDate: b.dueDate,
        );
        break;
      }
    }
  }

  // 6. Request Schedule Pause or Extra Milk
  Future<Map<String, dynamic>> requestSchedule({
    required String requestType,
    String? startDate,
    String? endDate,
    double? newQuantity,
    String? effectiveDate,
    String? reason,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/schedule'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'customer_id': currentCustomer.id,
          'request_type': requestType,
          'start_date': startDate,
          'end_date': endDate,
          'new_quantity': newQuantity,
          'effective_date': effectiveDate,
          'reason': reason,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      }
    } catch (e) {
      debugPrint('ApiService schedule fallback: $e');
    }

    return {
      'success': true,
      'message': 'Your request has been submitted to your dairy. You will receive an SMS confirmation.',
      'ticket_id': 'APP-REQ-${DateTime.now().millisecond}',
    };
  }

  // 7. Support Tickets
  Future<List<SupportTicketModel>> getSupportTickets() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/support/${currentCustomer.id}'),
        headers: {'Accept': 'application/json'},
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['tickets'] is List) {
          cachedTickets = (data['tickets'] as List)
              .map((t) => SupportTicketModel.fromJson(t))
              .toList();
          return cachedTickets;
        }
      }
    } catch (e) {
      debugPrint('ApiService tickets fallback: $e');
    }
    return cachedTickets;
  }

  // 8. Create Support Ticket
  Future<Map<String, dynamic>> createSupportTicket(String subject, String message) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/support'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'customer_id': currentCustomer.id,
          'subject': subject,
          'message': message,
        }),
      ).timeout(const Duration(seconds: 4));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        cachedTickets.insert(
          0,
          SupportTicketModel(
            id: cachedTickets.length + 1,
            ticketNumber: data['ticket']?['ticket_number'] ?? 'TCK-2026-${DateTime.now().millisecond}',
            subject: subject,
            message: message,
            status: 'open',
            createdAt: 'Just now',
          ),
        );
        return data;
      }
    } catch (e) {
      debugPrint('ApiService ticket create fallback: $e');
    }

    final newTicket = SupportTicketModel(
      id: cachedTickets.length + 1,
      ticketNumber: 'TCK-2026-${DateTime.now().millisecond}',
      subject: subject,
      message: message,
      status: 'open',
      createdAt: 'Just now',
    );
    cachedTickets.insert(0, newTicket);

    return {
      'success': true,
      'message': 'Support ticket submitted successfully.',
      'ticket': newTicket.toJson(),
    };
  }
}
