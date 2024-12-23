import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ProfileDosen extends StatefulWidget {
  @override
  _ProfileDosenState createState() => _ProfileDosenState();
}

class _ProfileDosenState extends State<ProfileDosen> {
  Map<String, dynamic>? _profileData;

  @override
  void initState() {
    super.initState();
    fetchProfile();
  }

  Future<void> fetchProfile() async {
    const String apiUrl =
        'http://127.0.0.1:8000/api/profile'; // Ganti IP sesuai server
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    try {
      final response = await http.get(
        Uri.parse(apiUrl),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        setState(() {
          _profileData = jsonDecode(response.body);
        });
      } else {
        print('Gagal memuat profil: ${response.body}');
      }
    } catch (e) {
      print('Kesalahan: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFF051C3D),
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D),
        elevation: 0,
        title: Text('Profil Dosen', style: TextStyle(color: Colors.white)),
        centerTitle: true,
      ),
      body: _profileData == null
          ? Center(child: CircularProgressIndicator(color: Colors.white))
          : Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  SizedBox(height: 16),
                  buildProfileCard(
                      'Nama Pengguna', _profileData!['nama_pengguna']),
                  SizedBox(height: 16),
                  buildProfileCard('Nama Lengkap', _profileData!['nama']),
                  SizedBox(height: 16),
                  buildProfileCard('Email', _profileData!['email']),
                  SizedBox(height: 16),
                  buildProfileCard('NIP', _profileData!['nip']),
                  Spacer(),
                  Align(
                    alignment: Alignment.center,
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor:
                            Color(0xFFF4D35E), // Warna kuning cerah
                        padding:
                            EdgeInsets.symmetric(vertical: 16, horizontal: 32),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(8),
                        ),
                      ),
                      child: Text(
                        "Kembali",
                        style: TextStyle(fontSize: 16, color: Colors.black),
                      ),
                    ),
                  ),
                ],
              ),
            ),
    );
  }

  Widget buildProfileCard(String label, String value) {
    return Container(
      width: double.infinity, // Mengatur lebar container agar penuh
      padding: EdgeInsets.symmetric(vertical: 12, horizontal: 16),
      decoration: BoxDecoration(
        color: Color(0xFF1A2A3A),
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: Colors.white70),
        boxShadow: [
          BoxShadow(
            color: Colors.black26,
            blurRadius: 4,
            offset: Offset(0, 4), // Bayangan sedikit ke bawah
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: TextStyle(fontSize: 14, color: Colors.white70),
          ),
          SizedBox(height: 4),
          Text(
            value,
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
        ],
      ),
    );
  }
}
