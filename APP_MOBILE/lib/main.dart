import 'package:flutter/material.dart';
import 'package:pbl/pages/riwayat_pelatihan.dart';
import 'package:pbl/pages/dataku_page.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/notif_page.dart';
import 'package:pbl/pages/riwayat_sertifikasi.dart';
import 'package:pbl/pages/surat_tugas.dart';
import 'pages/landing_page.dart';
import 'pages/login_page.dart';
import 'pages/dosen_home.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      initialRoute: '/',
      routes: {
        // '/': (context) => Dataku(),
        '/': (context) => LandingPage(),
        '/login': (context) => LoginPage(),
        '/dosen_home': (context) => DosenHome(),
        '/notif': (context) => NotifikasiPage(),
        '/surat_tugas': (context) => SuratTugas(),
        '/info_serpel': (context) => InfoSerpel(),
        '/riwayat_pelatihan': (context) => RiwayatPelatihan(),
        '/riwayat_sertifikasi': (context) => RiwayatSertifikasi(),
        '/dataku': (context) => Dataku(),
      },
      debugShowCheckedModeBanner: false,
    );
  }
}
