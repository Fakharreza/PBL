import 'package:flutter/material.dart';

class LoginPage extends StatelessWidget {
  // Data pengguna (array sederhana)
  final List<Map<String, String>> users = [
    {'username': 'dosen', 'password': 'dosen123'},
  ];

  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFF051C3D), // Dark blue background
      body: Column(
        children: [
          // Header dengan tulisan "Welcome Back!"
          Container(
            width: double.infinity,
            color: Color(0xFF051C3D), // Background biru
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
          ),
          // Expanded Container untuk background putih
          Expanded(
            child: Container(
              width: double.infinity,
              color: Color(0xFFE0E0E0),
              padding: EdgeInsets.all(24),
              child: _buildLoginForm(context),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoginForm(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Username',
          style: TextStyle(
            fontSize: 14,
            color: Colors.black,
            fontWeight: FontWeight.bold,
          ),
        ),
        SizedBox(height: 8),
        TextField(
          controller: _usernameController, // Controller untuk username
          decoration: InputDecoration(
            hintText: 'dosenn',
            prefixIcon: Icon(Icons.person),
            filled: true,
            fillColor: Colors.white,
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: BorderSide(color: Colors.black38),
            ),
          ),
        ),
        SizedBox(height: 16),
        Text(
          'Password',
          style: TextStyle(
            fontSize: 14,
            color: Colors.black,
            fontWeight: FontWeight.bold,
          ),
        ),
        SizedBox(height: 8),
        TextField(
          controller: _passwordController, // Controller untuk password
          obscureText: true,
          decoration: InputDecoration(
            hintText: '••••••••',
            prefixIcon: Icon(Icons.lock),
            suffixIcon: Icon(Icons.visibility_off),
            filled: true,
            fillColor: Colors.white,
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: BorderSide(color: Colors.black38),
            ),
          ),
        ),
        SizedBox(height: 8),
        Align(
          alignment: Alignment.centerRight,
          child: TextButton(
            onPressed: () {
              // Add forgot password logic
            },
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
          onPressed: () {
            _handleLogin(context); // Panggil logika login
          },
          child: Text('Log In'),
          style: ElevatedButton.styleFrom(
            backgroundColor: Color(0xFF051C3D), // Dark blue button
            foregroundColor: Colors.white,
            minimumSize: Size.fromHeight(48),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(8),
            ),
          ),
        ),
      ],
    );
  }

  void _handleLogin(BuildContext context) {
    String username = _usernameController.text;
    String password = _passwordController.text;

    // Cek apakah username dan password cocok dengan data di array
    bool isValidUser = users.any((user) =>
        user['username'] == username && user['password'] == password);

    if (isValidUser) {
      // Jika login berhasil, navigasi ke halaman dashboard
      Navigator.pushNamed(context, '/dosen_home');
    } else {
      // Jika login gagal
      showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: Text('Login Failed'),
          content: Text('Invalid username or password.'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context), // Tutup dialog
              child: Text('Try Again'),
            ),
          ],
        ),
      );
    }
  }
}