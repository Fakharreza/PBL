import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:pbl/pages/dataku_page.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart';

class InfoSerpel extends StatefulWidget {
  @override
  _InfoSerpelState createState() => _InfoSerpelState();
}

class _InfoSerpelState extends State<InfoSerpel> {
  String _selectedType = 'pelatihan'; // Default pilihan dropdown
  List<dynamic> _items = [];
  bool _isLoading = false;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _fetchData(); // Ambil data pertama kali
  }

  Future<void> _fetchData() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    try {
      final url = Uri.parse(
          'http://127.0.0.1:8000/api/info?type=$_selectedType'); // Ganti dengan URL API Anda
      final response = await http.get(url);

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        setState(() {
          _items = data; // Asumsikan API mengembalikan array
        });
      } else {
        setState(() {
          _errorMessage =
              jsonDecode(response.body)['message'] ?? 'Gagal memuat data';
        });
      }
    } catch (e) {
      setState(() {
        _errorMessage = 'Terjadi kesalahan: $e';
      });
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D), // Dark blue
        iconTheme: IconThemeData(
          color: Colors.white, // Icon warna putih
        ),
        title: Text(
          'Info Pelatihan dan Sertifikasi',
          style: TextStyle(
            fontSize: 20,
            color: Colors.white,
          ),
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            // Dropdown untuk memilih pelatihan atau sertifikasi
            DropdownButtonFormField<String>(
              value: _selectedType,
              items: [
                DropdownMenuItem(value: 'pelatihan', child: Text('Pelatihan')),
                DropdownMenuItem(
                    value: 'sertifikasi', child: Text('Sertifikasi')),
              ],
              onChanged: (value) {
                if (value != null) {
                  setState(() {
                    _selectedType = value;
                  });
                  _fetchData(); // Ambil data ulang saat pilihan berubah
                }
              },
              decoration: InputDecoration(
                labelText: 'Pilih Tipe',
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8.0),
                ),
              ),
            ),
            SizedBox(height: 16),
            // Tampilkan loading, error, atau data
            Expanded(
              child: _isLoading
                  ? Center(child: CircularProgressIndicator())
                  : _errorMessage != null
                      ? Center(child: Text(_errorMessage!))
                      : ListView.builder(
                          itemCount: _items.length,
                          itemBuilder: (context, index) {
                            final item = _items[index];

                            // Tampilan untuk pelatihan
                            if (_selectedType == 'pelatihan') {
                              return Card(
                                margin: EdgeInsets.symmetric(vertical: 8.0),
                                child: ListTile(
                                  title: Text(item['nama_pelatihan'] ??
                                      'Nama tidak tersedia'),
                                  subtitle: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(
                                          'Lokasi: ${item['lokasi_pelatihan'] ?? '-'}'),
                                      Text(
                                          'Level: ${item['level_pelatihan'] ?? '-'}'),
                                      Text(
                                          'Tanggal: ${item['tanggal_mulai'] ?? '-'} - ${item['tanggal_selesai'] ?? '-'}'),
                                      Text(
                                          'Kuota: ${item['kuota_peserta'] ?? '-'}'),
                                      Text('Biaya: ${item['biaya'] ?? '-'}'),
                                    ],
                                  ),
                                ),
                              );
                            }
                            // Tampilan untuk sertifikasi
                            else {
                              return Card(
                                margin: EdgeInsets.symmetric(vertical: 8.0),
                                child: ListTile(
                                  title: Text(item['nama_sertifikasi'] ??
                                      'Nama tidak tersedia'),
                                  subtitle: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(
                                          'Level: ${item['level_sertifikasi'] ?? '-'}'),
                                      Text(
                                          'Tanggal: ${item['tanggal_mulai'] ?? '-'} - ${item['tanggal_selesai'] ?? '-'}'),
                                      Text(
                                          'Kuota: ${item['kuota_peserta'] ?? '-'}'),
                                      Text(
                                          'Masa Berlaku: ${item['masa_berlaku'] ?? '-'}'),
                                    ],
                                  ),
                                ),
                              );
                            }
                          },
                        ),
            ),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        backgroundColor: Color(0xFF051C3D),
        selectedItemColor: Colors.white,
        unselectedItemColor: Colors.white,
        items: [
          BottomNavigationBarItem(
            icon: Icon(Icons.home_outlined),
            label: 'Beranda',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.info_outline),
            label: 'Info Pelatihan',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.description_outlined),
            label: 'Surat Tugas',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.folder_outlined),
            label: 'Dataku',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            label: 'Profile',
          ),
        ],
        selectedFontSize: 12,
        unselectedFontSize: 12,
        currentIndex: 1, // Current tab index
        onTap: (index) {
          if (index == 0) {
            // Navigasi ke halaman Surat Tugas
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => DosenHome()),
            );
          } else if (index == 1) {
            // Navigasi ke halaman profile
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => InfoSerpel()),
            );
          } else if (index == 2) {
            // Navigasi ke halaman profile
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => SuratTugas()),
            );
          } else if (index == 3) {
            // Navigasi ke halaman profile
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => Dataku()),
            );
          }else if (index == 4) {
            // Navigasi ke halaman profile
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => ProfileDosen()),
            );
          }
        },
      ),
    );
  }
}
