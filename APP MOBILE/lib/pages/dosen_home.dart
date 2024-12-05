import 'package:flutter/material.dart';
import 'package:pbl/pages/data_serpel.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart'; // Import halaman SuratTugasPage

class DosenHome extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFECECEC), // Light gray background
      body: Column(
        children: [
          // Header
          Container(
            color: Color(0xFF051C3D), // Dark blue background
            padding: EdgeInsets.symmetric(horizontal: 24, vertical: 24),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Logo dan Teks
                Row(
                  children: [
                    Image.asset(
                      'assets/images/logo_polinema.png',
                      width: 50,
                    ),
                    SizedBox(width: 8),
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'POLINEMA',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        Text(
                          'Manage Pelatihan & Sertifikasi',
                          style: TextStyle(
                            color: Color(0xFFF4D35E),
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
                SizedBox(height: 24),
                // Teks Welcome dan Role dengan Ikon Notifikasi
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Welcome Back!',
                          style: TextStyle(
                            fontSize: 14,
                            color: Color(0xFFF4D35E),
                          ),
                        ),
                        Text(
                          'Dosen',
                          style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),
                    IconButton(
                      onPressed: () {
                        Navigator.pushNamed(context, '/notif');
                      },
                      icon: Icon(
                        Icons.notifications_none,
                        color: Colors.white,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          // Content
          Expanded(
            child: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.all(16.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Tabel Pelatihan dan Sertifikasi
                    Container(
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(8),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black12,
                            blurRadius: 4,
                            offset: Offset(0, 2),
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Judul Tabel
                          Padding(
                            padding: const EdgeInsets.all(16.0),
                            child: Text(
                              'Pelatihan Dan Sertifikasi Yang Anda Dapatkan',
                              style: TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: Colors.black,
                              ),
                            ),
                          ),
                          // Tabel
                          SingleChildScrollView(
                            scrollDirection: Axis.horizontal,
                            child: DataTable(
                              columnSpacing: 76.0, // Jarak antar kolom
                              headingRowColor:
                                  MaterialStateProperty.all(Color(0xFF051C3D)),
                              dataRowColor:
                                  MaterialStateProperty.all(Color(0xFFF5F5F5)),
                              border: TableBorder(
                                horizontalInside: BorderSide(
                                  width: 1,
                                  color: Colors.grey.shade300,
                                ),
                              ),
                              columns: const [
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'No.',
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                ),
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'Periode',
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                ),
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'Total Sertifikasi',
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                              rows: const [
                                DataRow(cells: [
                                  DataCell(Text(
                                    '1',
                                    style:
                                        TextStyle(fontWeight: FontWeight.bold),
                                  )),
                                  DataCell(Text('2020')),
                                  DataCell(Text('2')),
                                ]),
                                DataRow(cells: [
                                  DataCell(Text(
                                    '2',
                                    style:
                                        TextStyle(fontWeight: FontWeight.bold),
                                  )),
                                  DataCell(Text('2021')),
                                  DataCell(Text('0')),
                                ]),
                                DataRow(cells: [
                                  DataCell(Text(
                                    '3',
                                    style:
                                        TextStyle(fontWeight: FontWeight.bold),
                                  )),
                                  DataCell(Text('2023')),
                                  DataCell(Text('1')),
                                ]),
                                DataRow(cells: [
                                  DataCell(Text(
                                    '4',
                                    style:
                                        TextStyle(fontWeight: FontWeight.bold),
                                  )),
                                  DataCell(Text('2024')),
                                  DataCell(Text('1')),
                                ]),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                    // Jarak antara tabel dan Card pertama
                    SizedBox(height: 16),
                    // Card Data Pelatihan dan Sertifikasi
                    Card(
                      color: Colors
                          .white, // Menentukan warna background card menjadi putih
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      ),
                      elevation: 2,
                      margin: EdgeInsets.symmetric(horizontal: 4),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            // Judul
                            Text(
                              'Data Pelatihan dan Sertifikasi',
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 16,
                              ),
                            ),
                            SizedBox(height: 8),
                            Row(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Ikon di kiri
                                Icon(
                                  Icons.folder,
                                  size: 48,
                                  color: Color(0xFF051C3D),
                                ),
                                SizedBox(
                                    width: 16), // Jarak antara ikon dan teks
                                // Teks deskripsi
                                Expanded(
                                  child: Text(
                                    'Lihat data pelatihan dan sertifikasi yang telah anda didapatkan',
                                    style: TextStyle(
                                      fontSize: 14,
                                      color: Colors.black54,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            SizedBox(
                                height:
                                    16), // Jarak antara teks dan "READ MORE"
                            // READ MORE di kanan bawah
                            Align(
                              alignment: Alignment.centerRight,
                              child: Row(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  GestureDetector(
                                    onTap: () {
                                      // Navigasi ke halaman yang diinginkan saat "READ MORE" diklik
                                      Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                            builder: (context) => DataSerpel()),
                                      );
                                    },
                                    child: Text(
                                      'READ MORE',
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: Color(0xFF051C3D),
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                  SizedBox(width: 4),
                                  Icon(
                                    Icons.arrow_forward_ios,
                                    size: 14,
                                    color: Colors.black,
                                  ),
                                ],
                              ),
                            )
                          ],
                        ),
                      ),
                    ),
                    // Jarak antara Card pertama dan kedua
                    SizedBox(height: 16),
                    // Card Daftar Pelatihan dan Sertifikasi
                    Card(
                      color: Colors
                          .white, // Menentukan warna background card menjadi putih
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      ),
                      elevation: 2,
                      margin: EdgeInsets.symmetric(horizontal: 4),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            // Judul
                            Text(
                              'Daftar Pelatihan dan Sertifikasi',
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 16,
                              ),
                            ),
                            SizedBox(height: 8),
                            Row(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Ikon di kiri
                                Icon(
                                  Icons.list_alt,
                                  size: 48,
                                  color: Color(0xFF051C3D),
                                ),
                                SizedBox(
                                    width: 16), // Jarak antara ikon dan teks
                                // Teks deskripsi
                                Expanded(
                                  child: Text(
                                    'Lihat daftar pelatihan dan sertifikasi yang tersedia',
                                    style: TextStyle(
                                      fontSize: 14,
                                      color: Colors.black54,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            SizedBox(
                                height:
                                    16), // Jarak antara teks dan "READ MORE"
                            // READ MORE di kanan bawah
                            Align(
                              alignment: Alignment.centerRight,
                              child: Row(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  GestureDetector(
                                    onTap: () {
                                      // Navigasi ke halaman yang diinginkan saat "READ MORE" diklik
                                      Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                            builder: (context) => InfoSerpel()),
                                      );
                                    },
                                    child: Text(
                                      'READ MORE',
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: Color(0xFF051C3D),
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                  SizedBox(width: 4),
                                  Icon(
                                    Icons.arrow_forward_ios,
                                    size: 14,
                                    color: Colors.black,
                                  ),
                                ],
                              ),
                            )
                          ],
                        ),
                      ),
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
        type: BottomNavigationBarType.fixed, // Menampilkan semua item
        backgroundColor: Color(0xFF051C3D), // Dark blue background
        selectedItemColor: Color(0xFFF4D35E), // Yellow for selected icon
        unselectedItemColor: Colors.white,
        selectedLabelStyle: TextStyle(fontSize: 12),
        unselectedLabelStyle: TextStyle(fontSize: 12),
        showSelectedLabels: true,
        showUnselectedLabels: true,
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
        currentIndex: 0, // Indeks menu aktif
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
          } else if (index == 4) {
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
