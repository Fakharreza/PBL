import 'package:flutter/material.dart';
import 'package:pbl/pages/data_serpel.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart';

class NotifikasiPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D), // Dark blue
        iconTheme: IconThemeData(
          color: Colors.white, // Ini akan mengubah warna arrow menjadi putih
        ),
        title: Text(
          'Notifikasi',
          style: TextStyle(
            fontSize: 20,
            color: Colors.white,
          ),
        ),
      ),
      backgroundColor: Color(0xFFF5F5F5), // Light gray background
      body: Column(
        children: [
          // Pencarian
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: TextField(
              decoration: InputDecoration(
                contentPadding: EdgeInsets.symmetric(vertical: 10),
                hintText: 'Pencarian',
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
          // Notifikasi
          Expanded(
            child: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Notifikasi Hari Ini
                    Text(
                      'Hari ini, 22 Sept 2024',
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 16,
                        color: Colors.black54,
                      ),
                    ),
                    SizedBox(height: 8),
                    NotificationCard(
                      icon: Icons.notifications_active,
                      title: 'Peringatan: Jangan lewatkan ini!',
                      message:
                          'Pelatihan "Cloud Computing" akan dimulai pada 25 Oktober 2024. Pastikan Anda sudah mempersiapkan semua yang diperlukan.',
                      color: Colors.amber,
                    ),
                    SizedBox(height: 16),
                    NotificationCard(
                      icon: Icons.warning_amber_rounded,
                      title:
                          'Warning: Ada risiko jika tidak segera diambil tindakan!',
                      message:
                          'Sertifikat pelatihan belum diinput. Mohon unggah sertifikat sebelum 26 Oktober 2024.',
                      color: Colors.redAccent,
                    ),
                    SizedBox(height: 24),
                    // Notifikasi Sebelumnya
                    Text(
                      'Rabu, 20 Sept 2024',
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 16,
                        color: Colors.black54,
                      ),
                    ),
                    SizedBox(height: 8),
                    NotificationCard(
                      icon: Icons.warning_amber_rounded,
                      title:
                          'Warning: Ada risiko jika tidak segera diambil tindakan!',
                      message:
                          'Sertifikat pelatihan belum diinput. Mohon unggah sertifikat sebelum 26 Oktober 2024.',
                      color: Colors.redAccent,
                    ),
                  ],
                ),
              ),
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
        selectedFontSize: 12, // Ukuran font untuk item yang dipilih
        unselectedFontSize: 12, // Ukuran font untuk item yang tidak dipilih
        currentIndex: 1, // Menu aktif untuk halaman ini
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

class NotificationCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String message;
  final Color color;

  const NotificationCard({
    Key? key,
    required this.icon,
    required this.title,
    required this.message,
    required this.color,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: double.infinity, // Membuat kartu memiliki lebar penuh
      child: Card(
        color: Colors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
        elevation: 3,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Icon(
                icon,
                color: color,
                size: 32,
              ),
              SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 14,
                        color: Colors.black,
                      ),
                      maxLines: 1, // Membatasi teks menjadi 1 baris
                      overflow: TextOverflow
                          .ellipsis, // Potong teks yang terlalu panjang
                    ),
                    SizedBox(height: 8),
                    Text(
                      message,
                      style: TextStyle(
                        fontSize: 12,
                        color: Colors.black87,
                      ),
                      maxLines: 2, // Membatasi teks menjadi 2 baris
                      overflow: TextOverflow
                          .ellipsis, // Potong teks yang terlalu panjang
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
