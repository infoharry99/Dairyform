import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../services/dairy_api_service.dart';
import '../widgets/primary_button.dart';
import 'admin_main_navigation_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _loginController = TextEditingController(text: 'dairy@milkflow.demo');
  final _passwordController = TextEditingController(text: 'password');
  bool _obscurePassword = true;
  bool _isLoading = false;

  @override
  void dispose() {
    _loginController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _handleLogin() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);
    final res = await DairyApiService().login(
      _loginController.text.trim(),
      _passwordController.text,
    );
    setState(() => _isLoading = false);

    if (!mounted) return;

    if (res['success'] == true) {
      Navigator.of(context).pushReplacement(
        MaterialPageRoute(builder: (_) => const AdminMainNavigationScreen()),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(res['message'] ?? 'Login failed'),
          backgroundColor: AppColors.danger,
        ),
      );
    }
  }

  void _fillDemoCredentials() {
    _loginController.text = 'dairy@milkflow.demo';
    _passwordController.text = 'password';
    _handleLogin();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 24),
            child: Form(
              key: _formKey,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Center(
                    child: Container(
                      width: 76,
                      height: 76,
                      decoration: BoxDecoration(
                        color: const Color(0xFF0F172A),
                        borderRadius: BorderRadius.circular(22),
                      ),
                      child: const Icon(
                        Icons.storefront_rounded,
                        size: 40,
                        color: AppColors.primaryLight,
                      ),
                    ),
                  ),
                  const SizedBox(height: 20),
                  const Text(
                    'Dairy Admin Portal',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.w800,
                      color: AppColors.textPrimary,
                      letterSpacing: -0.5,
                    ),
                  ),
                  const SizedBox(height: 6),
                  const Text(
                    'Manage customers, record daily morning & evening milk deliveries, invoices and online collections',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 13,
                      color: AppColors.textSecondary,
                      height: 1.4,
                    ),
                  ),
                  const SizedBox(height: 32),

                  // Email or Phone Field
                  const Text(
                    'Admin Email / Phone',
                    style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600, color: AppColors.textPrimary),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: _loginController,
                    decoration: const InputDecoration(
                      hintText: 'e.g. dairy@milkflow.demo or 9826012345',
                      prefixIcon: Icon(Icons.email_outlined, size: 20, color: AppColors.textMuted),
                    ),
                    validator: (val) => (val == null || val.trim().isEmpty) ? 'Please enter email or phone' : null,
                  ),
                  const SizedBox(height: 18),

                  // Password Field
                  const Text(
                    'Password',
                    style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600, color: AppColors.textPrimary),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: _passwordController,
                    obscureText: _obscurePassword,
                    decoration: InputDecoration(
                      hintText: '••••••••',
                      prefixIcon: const Icon(Icons.lock_outline_rounded, size: 20, color: AppColors.textMuted),
                      suffixIcon: IconButton(
                        icon: Icon(
                          _obscurePassword ? Icons.visibility_off_outlined : Icons.visibility_outlined,
                          size: 20,
                          color: AppColors.textMuted,
                        ),
                        onPressed: () => setState(() => _obscurePassword = !_obscurePassword),
                      ),
                    ),
                    validator: (val) => (val == null || val.isEmpty) ? 'Please enter password' : null,
                  ),
                  const SizedBox(height: 24),

                  // Submit Button
                  PrimaryButton(
                    text: 'Sign In to Dairy Dashboard',
                    icon: Icons.login_rounded,
                    isLoading: _isLoading,
                    onPressed: _handleLogin,
                  ),
                  const SizedBox(height: 18),

                  // 1-Click Demo Login Box
                  Container(
                    padding: const EdgeInsets.all(14),
                    decoration: BoxDecoration(
                      color: const Color(0xFFF8FAFC),
                      borderRadius: BorderRadius.circular(14),
                      border: Border.all(color: AppColors.border),
                    ),
                    child: Column(
                      children: [
                        const Row(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(Icons.bolt_rounded, size: 18, color: Color(0xFFD97706)),
                            SizedBox(width: 6),
                            Text(
                              'Instant Client Showcase Access',
                              style: TextStyle(
                                fontSize: 13,
                                fontWeight: FontWeight.w700,
                                color: AppColors.textPrimary,
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 6),
                        const Text(
                          'Login as Ramesh Patel (Shree Krishna Dairy Farm)',
                          style: TextStyle(fontSize: 12, color: AppColors.textSecondary),
                        ),
                        const SizedBox(height: 10),
                        SizedBox(
                          width: double.infinity,
                          child: ElevatedButton(
                            onPressed: _fillDemoCredentials,
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.white,
                              foregroundColor: const Color(0xFF0F172A),
                              elevation: 0,
                              side: const BorderSide(color: Color(0xFFCBD5E1), width: 1.2),
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                              padding: const EdgeInsets.symmetric(vertical: 10),
                            ),
                            child: const Text(
                              '1-Click Demo Sign In',
                              style: TextStyle(fontWeight: FontWeight.w700, fontSize: 13),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 24),

                  Center(
                    child: Text(
                      'MilkFlow SaaS Multi-tenant Platform • v1.0.0',
                      style: TextStyle(fontSize: 11, color: AppColors.textMuted),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
