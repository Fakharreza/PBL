import 'package:flutter/material.dart';
import 'package:pbl/pages/data_serpel.dart';
import 'package:pbl/pages/dosen_home.dart';
import 'package:pbl/pages/profile_dosen.dart';
import 'package:pbl/pages/surat_tugas.dart';

class InfoSerpel extends StatelessWidget {
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
      backgroundColor: Color(0xFFF5F5F5), // Light gray background
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Filter Section
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
                        value: 'Mata Kuliah',
                        child: Text('Mata Kuliah'),
                      ),
                      DropdownMenuItem(
                        value: 'Jaringan Komputer',
                        child: Text('Jaringan Komputer'),
                      ),
                      DropdownMenuItem(
                        value: 'Sistem Operasi',
                        child: Text('Sistem Operasi'),
                      ),
                    ],
                    onChanged: (value) {},
                    hint: Text('Mata Kuliah'),
                  ),
                ),
                SizedBox(width: 8),
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
                        value: 'Bidang Minat',
                        child: Text('Bidang Minat'),
                      ),
                      DropdownMenuItem(
                        value: 'Data Science',
                        child: Text('Data Science'),
                      ),
                      DropdownMenuItem(
                        value: 'Pengembangan Perangkat Lunak',
                        child: Text('Pengembangan Perangkat Lunak'),
                      ),
                    ],
                    onChanged: (value) {},
                    hint: Text('Bidang Minat'),
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

            // List of Training Info
            Expanded(
              child: ListView.builder(
                itemCount: 3, // Number of items in the list
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
                          index == 0
                              ? 'Pelatihan Cloud Computing : Tingkatkan K'
                              : index == 1
                                  ? 'Sertifikasi AWS Cloud Practitioner'
                                  : 'Pelatihan Cloud Computing : Tingkatkan K',
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16.0,
                            color: Colors.black,
                          ),
                        ),
                        SizedBox(height: 8.0),
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
                                text: 'Tanggal Pelaksanaan: ',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              TextSpan(text: '1 Desember 2024 - 5 Desember 2024\n'),
                              TextSpan(
                                text: 'Bidang Minat: ',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              TextSpan(
                                text: 'Jaringan dan Infrastruktur, Pengembangan Perangkat Lunak, Data Science & Big Data\n',
                              ),
                              TextSpan(
                                text: 'Mata Kuliah: ',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              TextSpan(
                                text: 'Jaringan Komputer, Sistem Operasi',
                              ),
                            ],
                          ),
                          style: TextStyle(fontSize: 14.0, color: Colors.black),
                        ),
                        SizedBox(height: 12.0),
                        Align(
                          alignment: Alignment.centerRight,
                          child: TextButton(
                            onPressed: () {
                              // "READ MORE" button action
                            },
                            child: Text('READ MORE'),
                          ),
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
