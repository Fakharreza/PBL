import 'package:flutter/material.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/services/auth_service.dart';

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _namaPenggunaController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();

  String? errorMessage;
  bool _obscurePassword = true;
  bool _isLoading = false;

  // Fungsi untuk login
  Future<void> _login() async {
    setState(() {
      _isLoading = true;
      errorMessage = null; // Reset error message
    });

    String namaPengguna = _namaPenggunaController.text.trim();
    String password = _passwordController.text.trim();

    try {
      final authService = AuthService();
      final result = await authService.login(namaPengguna, password);

      if (result != null && !result.containsKey('error')) {
        // Debug token setelah login
        final token = await authService.getToken();
        print('Token setelah login: $token');

        // Navigasi ke halaman home
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => DosenHome()),
        );
      } else {
        setState(() {
          errorMessage = result?['error'] ?? 'Login failed';
        });
      }
    } catch (e) {
      setState(() {
        errorMessage = 'An error occurred. Please check your connection.';
      });
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  void dispose() {
    _namaPenggunaController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFF051C3D),
      body: Column(
        children: [
          _buildHeader(),
          _buildLoginForm(),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      width: double.infinity,
      color: Color(0xFF051C3D),
      padding: EdgeInsets.symmetric(vertical: 24, horizontal: 16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Image.asset(
                'assets/images/logo_polinema.png',
                width: 50,
              ),
              SizedBox(width: 8),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'POLINEMA',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Text(
                    'Manage Pelatihan & Sertifikasi',
                    style: TextStyle(
                      color: Color(0xFFF4D35E),
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
            ],
          ),
          SizedBox(height: 16),
          Text(
            'Welcome Back!',
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoginForm() {
    return Expanded(
      child: Container(
        width: double.infinity,
        color: Color(0xFFE0E0E0),
        padding: EdgeInsets.all(24),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildTextField(
              label: 'Nama Pengguna',
              controller: _namaPenggunaController,
              icon: Icons.person,
              hintText: 'Enter your username',
            ),
            SizedBox(height: 16),
            _buildTextField(
              label: 'Password',
              controller: _passwordController,
              icon: Icons.lock,
              hintText: '••••••••',
              obscureText: _obscurePassword,
              suffixIcon: IconButton(
                icon: Icon(
                    _obscurePassword ? Icons.visibility_off : Icons.visibility),
                onPressed: () {
                  setState(() {
                    _obscurePassword = !_obscurePassword;
                  });
                },
              ),
            ),
            SizedBox(height: 8),
            Align(
              alignment: Alignment.centerRight,
              child: TextButton(
                onPressed: () {},
                child: Text(
                  'Forgot Password?',
                  style: TextStyle(
                    color: Colors.black,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
            SizedBox(height: 24),
            ElevatedButton(
              onPressed: _isLoading ? null : _login,
              child: _isLoading
                  ? CircularProgressIndicator(color: Colors.white)
                  : Text('Log In'),
              style: ElevatedButton.styleFrom(
                backgroundColor: Color(0xFF051C3D),
                foregroundColor: Colors.white,
                minimumSize: Size.fromHeight(48),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
            ),
            if (errorMessage != null)
              Padding(
                padding: const EdgeInsets.only(top: 16),
                child: Text(
                  errorMessage!,
                  style: TextStyle(color: Colors.red, fontSize: 14),
                ),
              ),
          ],
        ),
      ),
    );
  }

  Widget _buildTextField({
    required String label,
    required TextEditingController controller,
    required IconData icon,
    required String hintText,
    bool obscureText = false,
    Widget? suffixIcon,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: TextStyle(
            fontSize: 14,
            color: Colors.black,
            fontWeight: FontWeight.bold,
          ),
        ),
        SizedBox(height: 8),
        TextField(
          controller: controller,
          obscureText: obscureText,
          decoration: InputDecoration(
            hintText: hintText,
            prefixIcon: Icon(icon),
            suffixIcon: suffixIcon,
            filled: true,
            fillColor: Colors.white,
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: BorderSide(color: Colors.black38),
            ),
          ),
        ),
      ],
    );
  }
}
