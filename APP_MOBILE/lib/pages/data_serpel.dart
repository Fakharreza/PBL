import 'package:flutter/material.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart';

class DataSerpel extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D), // Dark blue
        iconTheme: IconThemeData(
          color: Colors.white, // Icon warna putih
        ),
        title: Text(
          'Data Pelatihan dan Sertifikasi',
          style: TextStyle(
            fontSize: 20,
            color: Colors.white,
          ),
        ),
      ),
      backgroundColor: Color(0xFFF5F5F5), // Light gray background color
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Dropdown Filter dan Pencarian
            Row(
              children: [
                Expanded(
                  child: DropdownButtonFormField<String>(
                    decoration: InputDecoration(
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8.0),
                      ),
                      contentPadding: EdgeInsets.symmetric(horizontal: 10.0),
                    ),
                    value: null,
                    items: [
                      DropdownMenuItem(
                        value: 'Periode',
                        child: Text('Periode'),
                      ),
                      DropdownMenuItem(
                        value: '2024',
                        child: Text('2024'),
                      ),
                      DropdownMenuItem(
                        value: '2023',
                        child: Text('2023'),
                      ),
                    ],
                    onChanged: (value) {
                      // Aksi ketika nilai dropdown berubah
                    },
                    hint: Text('Periode'),
                  ),
                ),
                SizedBox(width: 8),
                Expanded(
                  child: TextField(
                    decoration: InputDecoration(
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8.0),
                      ),
                      contentPadding: EdgeInsets.symmetric(horizontal: 10.0),
                      hintText: 'Pencarian',
                      suffixIcon: Icon(Icons.search),
                    ),
                  ),
                ),
              ],
            ),
            SizedBox(height: 16),

            // Daftar Pelatihan
            Expanded(
              child: ListView.builder(
                itemCount: 3, // Jumlah item dalam daftar
                itemBuilder: (context, index) {
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
                          'Pelatihan Cloud Computing : Tingkatkan K',
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16.0,
                            color: Colors.black,
                          ),
                        ),
                        SizedBox(height: 4.0),
                        Text(
                          'AWS Academy',
                          style: TextStyle(
                            fontSize: 14.0,
                            color: Colors.grey[700],
                          ),
                        ),
                        SizedBox(height: 8.0),
                        Text.rich(
                          TextSpan(
                            children: [
                              TextSpan(
                                text: 'Periode: ',
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 14.0,
                                  color: Colors.green,
                                ),
                              ),
                              TextSpan(
                                text: '2024\n',
                                style: TextStyle(fontSize: 14.0),
                              ),
                              TextSpan(
                                text: 'Tanggal Pelaksanaan: ',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              TextSpan(
                                text: '1 Desember 2024 - 5 Desember 2024\n',
                              ),
                              TextSpan(
                                text: 'Level Pelatihan: ',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              TextSpan(
                                text: 'Internasional',
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
          ],
        ),
      ),
      // Bottom Navigation Bar
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        backgroundColor: Color(0xFF051C3D), // Dark blue background
        selectedItemColor: Colors.white, // White icons when selected
        unselectedItemColor: Colors.white, // White icons when unselected
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
        currentIndex: 1, // Index sesuai tab "Info Pelatihan"
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
              MaterialPageRoute(builder: (context) => DataSerpel()),
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
