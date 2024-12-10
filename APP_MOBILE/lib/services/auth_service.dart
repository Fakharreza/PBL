import 'dart:convert'; // Pastikan ini diimpor
import 'package:http/http.dart' as http;

class AuthService {
  static const String baseUrl =
      "http://127.0.0.1:8000/api/login"; // Ganti dengan URL API-mu

  // Fungsi login
  static Future<Map<String, dynamic>> login(
      String namaPengguna, String password) async {
    final url = Uri.parse('$baseUrl/login');

    try {
      final response = await http.post(
        url,
        body: {
          'nama_pengguna': namaPengguna,
          'password': password,
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return {'success': true, 'data': data};
      } else {
        final error = jsonDecode(response.body);
        return {'success': false, 'message': error['message']};
      }
    } catch (e) {
      return {'success': false, 'message': 'Error: $e'};
    }
  }
}

