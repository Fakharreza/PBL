import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:pbl/pages/dataku_page.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'dart:convert';
import 'dart:html' as html;
import 'package:pbl/services/auth_service.dart';

class SuratTugas extends StatefulWidget {
  @override
  _SuratTugasState createState() => _SuratTugasState();
}

class _SuratTugasState extends State<SuratTugas> {
  final AuthService _authService = AuthService();
  List<Map<String, dynamic>> suratTugasList = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    loadSuratTugas();
  }

  Future<void> loadSuratTugas() async {
    try {
      final token = await _authService.getToken();
      final response = await http.get(
        Uri.parse('http://127.0.0.1:8000/api/surat-tugas'),
        headers: {'Authorization': 'Bearer $token'},
      );

      if (response.statusCode == 200) {
        print('Response body: ${response.body}'); // Debugging
        final List<dynamic> data = json.decode(response.body);
        setState(() {
          suratTugasList = List<Map<String, dynamic>>.from(data);
          isLoading = false;
        });
      }
    } catch (e) {
      print('Error loading surat tugas: $e');
      setState(() => isLoading = false);
    }
  }

  String determineTipe(Map<String, dynamic> suratTugas) {
    if (suratTugas['id_peserta_pelatihan'] != null) {
      return 'pelatihan';
    } else if (suratTugas['id_peserta_sertifikasi'] != null) {
      return 'sertifikasi';
    }
    return 'pelatihan'; // default value
  }

  Future<void> downloadFile(BuildContext context, dynamic id, String type) async {
    if (id == null) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text('ID surat tugas tidak valid'),
        backgroundColor: Colors.red,
      ));
      return;
    }

    final suratTugasId = id.toString();
    final token = await _authService.getToken();
    
    if (token == null) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text('Token tidak ditemukan. Silakan login ulang.'),
        backgroundColor: Colors.red,
      ));
      return;
    }

    final url = 'http://127.0.0.1:8000/api/download-surat-tugas/$suratTugasId?tipe=$type';
    print('Download URL: $url'); // Debugging

    final headers = {
      'Authorization': 'Bearer $token',
    };

    try {
      final response = await http.get(Uri.parse(url), headers: headers);
      print('Response status: ${response.statusCode}'); // Debugging
      
      if (response.statusCode == 200) {
        final contentType = response.headers['content-type'] ?? 'application/octet-stream';
        final blob = html.Blob([response.bodyBytes], contentType);
        final downloadUrl = html.Url.createObjectUrlFromBlob(blob);

        final anchor = html.AnchorElement(href: downloadUrl)
          ..target = '_blank'
          ..download = 'surat_tugas_$suratTugasId.pdf'
          ..click();

        html.Url.revokeObjectUrl(downloadUrl);

        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Text('File berhasil diunduh'),
          backgroundColor: Colors.green,
        ));
      } else {
        String errorMessage = 'Gagal mengunduh file.';
        if (response.statusCode == 403) {
          errorMessage = 'Anda tidak memiliki hak akses untuk file ini.';
        } else if (response.statusCode == 404) {
          errorMessage = 'File tidak ditemukan di server.';
        }

        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content: Text(errorMessage),
          backgroundColor: Colors.red,
        ));
      }
    } catch (e) {
      print('Download error: $e');
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text('Terjadi kesalahan: $e'),
        backgroundColor: Colors.red,
      ));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D),
        iconTheme: IconThemeData(color: Colors.white),
        title: Text(
          'Surat Tugas',
          style: TextStyle(fontSize: 20, color: Colors.white),
        ),
      ),
      backgroundColor: Color(0xFFF5F5F5),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: isLoading 
          ? Center(child: CircularProgressIndicator())
          : suratTugasList.isEmpty 
            ? Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.document_scanner_outlined, size: 64, color: Colors.grey),
                    SizedBox(height: 16),
                    Text(
                      'Tidak ada surat tugas tersedia',
                      style: TextStyle(fontSize: 18, color: Colors.grey[700]),
                    ),
                  ],
                ),
              )
            : ListView.builder(
                itemCount: suratTugasList.length,
                itemBuilder: (context, index) {
                  final suratTugas = suratTugasList[index];
                  final id = suratTugas['id_surat_tugas'];
                  final type = determineTipe(suratTugas);
                  
                  return Card(
                    elevation: 2,
                    margin: EdgeInsets.only(bottom: 12),
                    child: ListTile(
                      contentPadding: EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      title: Text(
                        suratTugas['nama_surat_tugas'] ?? 'Surat Tugas ${index + 1}',
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                      subtitle: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          SizedBox(height: 4),
                          Text(
                            'Tipe: ${type.toUpperCase()}',
                            style: TextStyle(color: Colors.grey[600]),
                          ),
                        ],
                      ),
                      trailing: ElevatedButton.icon(
                        onPressed: id != null ? () => downloadFile(context, id, type) : null,
                        icon: Icon(Icons.download, size: 20),
                        label: Text('Download'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Color(0xFF051C3D),
                          foregroundColor: Colors.white,
                          padding: EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                      ),
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