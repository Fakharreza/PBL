import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  // static const String _baseUrl =
  //     'http://127.0.0.1:8000/api/login'; // URL API login

  // Fungsi login
  Future<Map<String, dynamic>?> login(String namaPengguna, String password) async {
  const String apiUrl = 'http://127.0.0.1:8000/api/login'; // Ganti IP jika diperlukan

  try {
    // Kirim request POST ke API
    final response = await http.post(
      Uri.parse(apiUrl),
      headers: {'Accept': 'application/json'},
      body: {'nama_pengguna': namaPengguna, 'password': password},
    );

    // Proses respons
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      final token = data['token']; // Ambil token dari respons

      if (token != null) {
        // Simpan token ke SharedPreferences
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', token);
        print('Token berhasil disimpan: $token');

        // Simpan nama pengguna di SharedPreferences (seperti pada contoh kedua)
        final nama = data['user']['nama']; // Ambil nama pengguna
        if (nama != null) {
          await prefs.setString('nama', nama); // Simpan nama
          print('Nama pengguna berhasil disimpan: $nama');
        }

        return data; // Kembalikan data respons
      } else {
        print('Token tidak ditemukan dalam respons API');
        return {'error': 'Token tidak ditemukan'};
      }
    } else {
      print('Login gagal dengan status: ${response.statusCode}');
      return {'error': 'Login failed'};
    }
  } catch (e) {
    print('Error saat login: $e');
    return {'error': 'Terjadi kesalahan koneksi'};
  }
}


  // Menyimpan token
  Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('token', token);
    print('Token berhasil disimpan: $token'); // Log untuk memastikan token disimpan
  }

  // Mengambil token
  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    print('Token dari SharedPreferences: $token'); // Log untuk debug
    return token;
  }

  Future<bool> logout() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.clear();
      return true;
    } catch (e) {
      print('Error during logout: $e');
      return false;
    }
  }

  Future<bool> isLoggedIn() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      return prefs.getString('token') != null;
    } catch (e) {
      return false;
    }
  }
}
