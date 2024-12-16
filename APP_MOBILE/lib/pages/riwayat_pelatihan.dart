import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:pbl/services/auth_service.dart';
import 'package:pbl/pages/dataku_page.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart';

class RiwayatPelatihan extends StatefulWidget {
  @override
  _RiwayatPelatihanState createState() => _RiwayatPelatihanState();
}

class _RiwayatPelatihanState extends State<RiwayatPelatihan> {
  List<dynamic> dataPelatihan = []; // Menyimpan daftar data pelatihan
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    fetchData(); // Ambil data dari API saat halaman dimuat
  }

  /// Fungsi untuk mengambil data dari API
  Future<void> fetchData() async {
    const String apiUrl = 'http://10.0.2.2:8000/api/pelatihan'; // Ubah dengan IP Laravel Anda
    final authService = AuthService();

    try {
      // Ambil token dari SharedPreferences
      final token = await authService.getToken();
      if (token == null) throw Exception('Token tidak ditemukan');

      // Kirim request GET ke API
      final response = await http.get(
        Uri.parse(apiUrl),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final jsonResponse = jsonDecode(response.body);
        setState(() {
          dataPelatihan = jsonResponse; // Respons berupa array JSON
          isLoading = false;
        });
      } else {
        print('Gagal memuat data: ${response.statusCode}');
        throw Exception('Gagal memuat data pelatihan');
      }
    } catch (e) {
      print('Error: $e');
      setState(() {
        isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal memuat data pelatihan')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D), // Dark blue
        iconTheme: IconThemeData(color: Colors.white),
        title: Text(
          'Data Pelatihan',
          style: TextStyle(fontSize: 20, color: Colors.white),
        ),
      ),
      backgroundColor: Color(0xFFF5F5F5), // Light gray background
      body: isLoading
          ? Center(child: CircularProgressIndicator()) // Loading Indicator
          : dataPelatihan.isEmpty
              ? Center(child: Text('Data pelatihan tidak ditemukan')) // Jika kosong
              : Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: ListView.builder(
                    itemCount: dataPelatihan.length,
                    itemBuilder: (context, index) {
                      final item = dataPelatihan[index];
                      return Container(
                        margin: EdgeInsets.only(bottom: 16.0),
                        padding: EdgeInsets.all(12.0),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(8.0),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.grey.withOpacity(0.3),
                              spreadRadius: 2,
                              blurRadius: 5,
                              offset: Offset(0, 3),
                            ),
                          ],
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              item['nama_pelatihan'] ?? 'Nama tidak tersedia',
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 16.0,
                                color: Colors.black,
                              ),
                            ),
                            SizedBox(height: 4.0),
                            // Text(
                            //   'Penyelenggara: ${item['id_jenis_pelatihan_sertifikasi'] ?? '-'}',
                            //   style: TextStyle(fontSize: 14.0, color: Colors.grey[700]),
                            // ),
                            SizedBox(height: 8.0),
                            Text.rich(
                              TextSpan(
                                children: [
                                  TextSpan(
                                    text: 'Tanggal Pelaksanaan: ',
                                    style: TextStyle(fontWeight: FontWeight.bold),
                                  ),
                                  TextSpan(
                                    text: '${item['waktu_pelatihan'] ?? '-'}\n',
                                  ),
                                  TextSpan(
                                    text: 'Lokasi: ',
                                    style: TextStyle(fontWeight: FontWeight.bold),
                                  ),
                                  TextSpan(
                                    text: '${item['lokasi_pelatihan'] ?? '-'}',
                                  ),
                                ],
                              ),
                              style: TextStyle(fontSize: 14.0, color: Colors.black),
                            ),
                          ],
                        ),
                      );
                    },
                  ),
                ),
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        backgroundColor: Color(0xFF051C3D),
        selectedItemColor: Colors.white,
        unselectedItemColor: Colors.white,
        items: [
          BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Beranda'),
          BottomNavigationBarItem(icon: Icon(Icons.info_outline), label: 'Info Pelatihan'),
          BottomNavigationBarItem(icon: Icon(Icons.description_outlined), label: 'Surat Tugas'),
          BottomNavigationBarItem(icon: Icon(Icons.folder_outlined), label: 'Dataku'),
          BottomNavigationBarItem(icon: Icon(Icons.person_outline), label: 'Profile'),
        ],
        currentIndex: 1,
        onTap: (index) {
          if (index == 0) {
            Navigator.push(context, MaterialPageRoute(builder: (context) => DosenHome()));
          } else if (index == 1) {
            Navigator.push(context, MaterialPageRoute(builder: (context) => InfoSerpel()));
          } else if (index == 2) {
            Navigator.push(context, MaterialPageRoute(builder: (context) => SuratTugas()));
          } else if (index == 3) {
            Navigator.push(context, MaterialPageRoute(builder: (context) => Dataku()));
          } else if (index == 4) {
            Navigator.push(context, MaterialPageRoute(builder: (context) => ProfileDosen()));
          }
        },
      ),
    );
  }
}
