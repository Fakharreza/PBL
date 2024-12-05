import 'package:flutter/material.dart';

class LandingPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFF051C3D), // Dark blue background
      body: Column(
        children: [
          // Header
          Flexible(
            flex: 2,
            child: Container(
              width: double.infinity,
              padding: EdgeInsets.symmetric(vertical: 24, horizontal: 24),
              child: Row(
                children: [
                  Image.asset(
                    'assets/images/logo_polinema.png', // Path to logo
                    height: 60,
                  ),
                  SizedBox(width: 16),
                  Text(
                    'POLITEKNIK NEGERI MALANG',
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                ],
              ),
            ),
          ),
          // Main Content
          Flexible(
            flex: 8,
            child: Padding(
              padding: EdgeInsets.symmetric(horizontal: 24),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'POLINEMA',
                    style: TextStyle(
                      fontSize: 54,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                      height: 1.2,
                    ),
                  ),
                  Text(
                    'Manage',
                    style: TextStyle(
                      fontSize: 54,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFFF4D35E),
                      height: 1.2,
                    ),
                  ),
                  Text(
                    'Pelatihan &',
                    style: TextStyle(
                      fontSize: 54,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFFF4D35E),
                      height: 1.2,
                    ),
                  ),
                  Text(
                    'Sertifikasi',
                    style: TextStyle(
                      fontSize: 54,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFFF4D35E),
                      height: 1.2,
                    ),
                  ),
                  SizedBox(height: 20),
                  // Centered Button
                  Center(
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.pushNamed(context, '/login'); // Navigasi ke halaman login
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Color(0xFFF4D35E), // Yellow button
                        padding: EdgeInsets.symmetric(
                          horizontal: 140,
                          vertical: 15,
                        ),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.zero, // Tombol kotak
                        ),
                      ),
                      child: Text(
                        "Let's Start",
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF051C3D), // Dark blue text
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
