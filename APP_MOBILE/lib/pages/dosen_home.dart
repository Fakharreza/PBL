import 'dart:convert'; // For converting response to JSON
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http; // To make HTTP requests
import 'package:pbl/pages/dataku_page.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:pbl/pages/riwayat_pelatihan.dart';
import 'package:pbl/pages/riwayat_sertifikasi.dart';
import 'package:pbl/pages/login_page.dart';
import 'package:pbl/services/auth_service.dart';
import 'package:pbl/pages/info_serpel.dart'; // Assuming this is the page for info
import 'package:pbl/pages/surat_tugas.dart'; // Assuming this is the page for Surat Tugas
import 'package:pbl/pages/profile_dosen.dart'; // Assuming this is the page for Profile Dosen

class DosenHome extends StatefulWidget {
  @override
  _DosenHomeState createState() => _DosenHomeState();
}

class _DosenHomeState extends State<DosenHome> {
  String _dosenName = "Dosen"; // Default jika tidak ada nama dosen
  List<dynamic> _riwayatData = []; // Data to display in the table
  bool _isLoading = true; // To handle loading state

  @override
  void initState() {
    super.initState();
    _loadDosenName();
    _fetchRiwayatData(); // Fetch data when the page is initialized
  }

  // Mengambil nama dosen dari SharedPreferences
  Future<void> _loadDosenName() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      _dosenName = prefs.getString('nama') ?? "Dosen"; // Default to "Dosen"
    });
  }

  // Fetch data from the API
  Future<void> _fetchRiwayatData() async {
    final user = await _getUser(); // Assuming the user is already logged in
    final response = await http.get(
      Uri.parse(
          'http://127.0.0.1:8000/api/riwayat/gabungan'), // Your API URL here
      headers: {
        'Authorization':
            'Bearer ${user['token']}', // If your API requires auth token
      },
    );

    if (response.statusCode == 200) {
      setState(() {
        _riwayatData =
            json.decode(response.body)['data']; // Parse the JSON response
        _isLoading = false;
      });
    } else {
      setState(() {
        _isLoading = false;
      });
      // Handle error response (e.g., show a message or retry)
    }
  }

  // Simulate getting user data, e.g., from SharedPreferences
  Future<Map<String, dynamic>> _getUser() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return {
      'token': prefs.getString('token'), // Fetch the token
    };
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFECECEC),
      body: Column(
        children: [
          // Header
          Container(
            color: Color(0xFF051C3D),
            padding: EdgeInsets.symmetric(horizontal: 24, vertical: 24),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Image.asset('assets/images/logo_polinema.png', width: 50),
                    SizedBox(width: 8),
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'POLINEMA',
                          style: TextStyle(
                              color: Colors.white,
                              fontSize: 16,
                              fontWeight: FontWeight.bold),
                        ),
                        Text(
                          'Manage Pelatihan & Sertifikasi',
                          style: TextStyle(
                              color: Color(0xFFF4D35E),
                              fontSize: 14,
                              fontWeight: FontWeight.bold),
                        ),
                      ],
                    ),
                  ],
                ),
                SizedBox(height: 24),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text('Welcome Back!',
                            style: TextStyle(
                                fontSize: 14, color: Color(0xFFF4D35E))),
                        Text(_dosenName,
                            style: TextStyle(
                                fontSize: 18,
                                fontWeight: FontWeight.bold,
                                color: Colors.white)),
                      ],
                    ),
                    Row(
                      children: [
                        // IconButton(
                        //   onPressed: () {
                        //     Navigator.pushNamed(context, '/notif');
                        //   },
                        //   icon: Icon(Icons.notifications_none,
                        //       color: Colors.white),
                        // ),
                        IconButton(
                          onPressed: () async {
                            await AuthService().logout();
                            Navigator.pushReplacement(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => LoginPage()),
                            );
                          },
                          icon: Icon(Icons.logout, color: Colors.white),
                        ),
                      ],
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
                  children: [
                    // Table to display Sertifikasi data
                    SizedBox(height: 16),
                    _isLoading
                        ? CircularProgressIndicator() // Show loading spinner
                        : SingleChildScrollView(
                            scrollDirection: Axis.horizontal,
                            child: DataTable(
                              columnSpacing: 50.0, // Mengurangi jarak antar kolom agar lebih pas
                              headingRowColor:
                                  MaterialStateProperty.all(Color(0xFF051C3D)),
                              dataRowColor:
                                  MaterialStateProperty.all(Color(0xFFF5F5F5)),
                              border: TableBorder(
                                horizontalInside: BorderSide(
                                    width: 1, color: Colors.grey.shade300),
                              ),
                              columns: const [
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'Periode',
                                      style: TextStyle(
                                          color: Colors.white,
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                ),
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'Total Sertifikasi',
                                      style: TextStyle(
                                          color: Colors.white,
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                ),
                                DataColumn(
                                  label: Expanded(
                                    child: Text(
                                      'Total Pelatihan',
                                      style: TextStyle(
                                          color: Colors.white,
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                ),
                              ],
                              rows: _riwayatData.map<DataRow>((item) {
                                return DataRow(cells: [
                                  DataCell(Text(item['tahun_periode'])),
                                  DataCell(
                                      Text('${item['total_sertifikasi']}')),
                                  DataCell(Text('${item['total_pelatihan']}')),
                                ]);
                              }).toList(),
                            )),
                    SizedBox(height: 20),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Expanded(
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          RiwayatPelatihan()));
                            },
                            style: ElevatedButton.styleFrom(
                              foregroundColor: Colors.white,
                              backgroundColor: Color(0xFF051C3D),
                              padding: EdgeInsets.symmetric(vertical: 16),
                              shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(12)),
                              elevation: 5,
                            ),
                            child: Column(
                              mainAxisSize: MainAxisSize.min,
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.school, size: 35),
                                SizedBox(height: 8),
                                Text('Lihat Riwayat Pelatihan',
                                    style: TextStyle(fontSize: 16)),
                              ],
                            ),
                          ),
                        ),
                        SizedBox(width: 16),
                        Expanded(
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          RiwayatSertifikasi()));
                            },
                            style: ElevatedButton.styleFrom(
                              foregroundColor: Colors.white,
                              backgroundColor: Color(0xFF051C3D),
                              padding: EdgeInsets.symmetric(vertical: 16),
                              shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(12)),
                              elevation: 5,
                            ),
                            child: Column(
                              mainAxisSize: MainAxisSize.min,
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.assignment_turned_in, size: 35),
                                SizedBox(height: 8),
                                Text('Lihat Riwayat Sertifikasi',
                                    style: TextStyle(fontSize: 16)),
                              ],
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        backgroundColor: Color(0xFF051C3D),
        selectedItemColor: Color(0xFFF4D35E),
        unselectedItemColor: Colors.white,
        showSelectedLabels: true,
        showUnselectedLabels: true,
        currentIndex: 0,
        onTap: (index) {
          switch (index) {
            case 0:
              Navigator.pushReplacement(
                context,
                MaterialPageRoute(builder: (context) => DosenHome()),
              );
              break;
            case 1:
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => InfoSerpel()),
              );
              break;
            case 2:
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => SuratTugas()),
              );
              break;
            case 3:
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => Dataku()),
              );
              break;
            case 4:
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => ProfileDosen()),
              );
              break;
          }
        },
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
      ),
    );
  }

  Widget _buildInfoCard(BuildContext context,
      {required String title,
      required String description,
      required IconData icon,
      required Widget destination}) {
    return Card(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(8),
      ),
      elevation: 2,
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Icon(
                  icon,
                  size: 48,
                  color: Color(0xFF051C3D),
                ),
                SizedBox(width: 16),
                Expanded(
                  child: Text(
                    description,
                    style: TextStyle(fontSize: 14, color: Colors.black54),
                  ),
                ),
              ],
            ),
            SizedBox(height: 16),
            Align(
              alignment: Alignment.centerRight,
              child: GestureDetector(
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => destination),
                  );
                },
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      'READ MORE',
                      style: TextStyle(
                        fontSize: 12,
                        color: Color(0xFF051C3D),
                        fontWeight: FontWeight.bold,
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
              ),
            ),
          ],
        ),
      ),
    );
  }
}
