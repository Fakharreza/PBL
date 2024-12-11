import 'package:flutter/material.dart';
import 'package:pbl/pages/data_serpel.dart';
import 'package:pbl/pages/info_serpel.dart';
import 'package:pbl/pages/notif_page.dart';
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
        // '/': (context) => InfoSerpel(),
        '/': (context) => LandingPage(),
        '/login': (context) => LoginPage(),
        '/dosen_home': (context) => DosenHome(),
        '/notif': (context) => NotifikasiPage(),
        '/surat_tugas': (context) => SuratTugas(),
        '/info_serpel': (context) => InfoSerpel(),
        '/data_serpel': (context) => DataSerpel(),
      },
      debugShowCheckedModeBanner: false,
    );
  }
}
