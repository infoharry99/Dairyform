import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/dairy_product_model.dart';
import '../services/dairy_api_service.dart';

class ProductsScreen extends StatefulWidget {
  const ProductsScreen({super.key});

  @override
  State<ProductsScreen> createState() => _ProductsScreenState();
}

class _ProductsScreenState extends State<ProductsScreen> {
  bool _isLoading = true;
  List<DairyProductModel> _products = [];

  @override
  void initState() {
    super.initState();
    _fetchProducts();
  }

  Future<void> _fetchProducts() async {
    setState(() => _isLoading = true);
    final list = await DairyApiService().getProducts();
    if (mounted) {
      setState(() {
        _products = list;
        _isLoading = false;
      });
    }
  }

  void _editProductPrice(DairyProductModel product) {
    final priceController = TextEditingController(text: product.price.toStringAsFixed(0));
    final stockController = TextEditingController(text: product.stock.toStringAsFixed(0));

    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: Text('Update ${product.name}'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Unit: ${product.unit}', style: const TextStyle(fontSize: 12, color: AppColors.textMuted)),
            const SizedBox(height: 12),
            const Text('Price per Unit (₹)', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
            const SizedBox(height: 6),
            TextField(controller: priceController, keyboardType: TextInputType.number, decoration: const InputDecoration(prefixIcon: Icon(Icons.currency_rupee_rounded, size: 18))),
            const SizedBox(height: 12),
            const Text('Current Stock Available', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
            const SizedBox(height: 6),
            TextField(controller: stockController, keyboardType: TextInputType.number, decoration: const InputDecoration(prefixIcon: Icon(Icons.inventory_2_outlined, size: 18))),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text('Cancel')),
          ElevatedButton(
            onPressed: () async {
              final newPrice = double.tryParse(priceController.text) ?? product.price;
              final newStock = double.tryParse(stockController.text) ?? product.stock;

              setState(() {
                product.price = newPrice;
                product.stock = newStock;
              });

              await DairyApiService().storeProduct(product);
              if (mounted) {
                Navigator.pop(context);
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(content: Text('Product updated successfully!'), backgroundColor: AppColors.primary),
                );
              }
            },
            style: ElevatedButton.styleFrom(backgroundColor: AppColors.primary),
            child: const Text('Save Changes'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Product Rates & Inventory'),
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
          : ListView.separated(
              padding: const EdgeInsets.all(16),
              itemCount: _products.length,
              separatorBuilder: (_, __) => const SizedBox(height: 12),
              itemBuilder: (context, index) {
                final p = _products[index];
                return Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(color: AppColors.border),
                  ),
                  child: Row(
                    children: [
                      Container(
                        width: 48,
                        height: 48,
                        decoration: BoxDecoration(
                          color: AppColors.primarySurface,
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: const Center(
                          child: Icon(Icons.shopping_bag_outlined, color: AppColors.primary, size: 24),
                        ),
                      ),
                      const SizedBox(width: 14),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              p.name,
                              style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: AppColors.textPrimary),
                            ),
                            const SizedBox(height: 2),
                            Text(
                              '₹${p.price.toStringAsFixed(0)} per ${p.unit} • Stock: ${p.stock.toStringAsFixed(0)} ${p.unit}',
                              style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                            ),
                          ],
                        ),
                      ),
                      IconButton(
                        icon: const Icon(Icons.edit_outlined, color: AppColors.primary, size: 20),
                        onPressed: () => _editProductPrice(p),
                      ),
                    ],
                  ),
                );
              },
            ),
    );
  }
}
