import 'package:flutter/material.dart';
import 'package:pbl/pages/data_serpel.dart';
import 'package:pbl/pages/detail_surat_tugas.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';  // Pastikan untuk import halaman Detail Surat Tugas

class SuratTugas extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D), // Dark blue
        iconTheme: IconThemeData(
          color: Colors.white, // Icon warna putih
        ),
        title: Text(
          'Surat Tugas',
          style: TextStyle(
            fontSize: 20,
            color: Colors.white,
          ),
        ),
      ),
      backgroundColor: Color(0xFFF5F5F5), // Background warna abu-abu muda
      body: Column(
        children: [
          // Pencarian Surat Tugas
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: TextField(
              decoration: InputDecoration(
                contentPadding: EdgeInsets.symmetric(vertical: 10),
                hintText: 'Pencarian Surat Tugas',
                prefixIcon: Icon(Icons.search),
                filled: true,
                fillColor: Colors.white,
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide.none,
                ),
              ),
            ),
          ),
          // Daftar Surat Tugas
          Expanded(
            child: ListView.builder(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              itemCount: 1, // Jumlah surat tugas (ubah sesuai kebutuhan)
              itemBuilder: (context, index) {
                return GestureDetector(
                  onTap: () {
                    // Navigasi ke halaman Detail Surat Tugas
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => DetailSuratTugasPage(
                          judulSurat: 'Surat Tugas ${index + 1}',
                          deskripsiSurat: 'Deskripsi singkat tentang surat tugas ${index + 1}.',
                          tanggal: '25 Oktober 2024', // Tanggal surat tugas
                          status: 'Aktif',
                        ),
                      ),
                    );
                  },
                  child: SuratTugasCard(
                    title: 'Surat Tugas ${index + 1}',
                    description: 'Deskripsi singkat tentang surat tugas ${index + 1}.',
                    date: '25 Oktober 2024', // Tanggal surat tugas
                  ),
                );
              },
            ),
          ),
        ],
      ),
      // Bottom Navigation Bar
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
        currentIndex: 2, // Surat Tugas sebagai menu aktif
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

class SuratTugasCard extends StatelessWidget {
  final String title;
  final String description;
  final String date;

  const SuratTugasCard({
    Key? key,
    required this.title,
    required this.description,
    required this.date,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      color: Colors.white,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      elevation: 3,
      margin: EdgeInsets.only(bottom: 16),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Judul Surat Tugas
            Text(
              title,
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 16,
                color: Colors.black,
              ),
            ),
            SizedBox(height: 8),
            // Deskripsi Surat Tugas
            Text(
              description,
              style: TextStyle(
                fontSize: 14,
                color: Colors.black87,
              ),
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
            ),
            SizedBox(height: 8),
            // Tanggal Surat Tugas
            Text(
              'Tanggal: $date',
              style: TextStyle(
                fontSize: 12,
                color: Colors.black45,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
