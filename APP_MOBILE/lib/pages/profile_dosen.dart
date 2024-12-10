import 'package:flutter/material.dart';

class ProfileDosen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFF051C3D), // Warna latar belakang gelap
      appBar: AppBar(
        backgroundColor: Color(0xFF051C3D),
        elevation: 0,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.white),
          onPressed: () {
            Navigator.pushNamed(context, '/dosen_home');
          },
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // Avatar Profile
            CircleAvatar(
              radius: 50,
              backgroundColor: Colors.grey.shade300,
              child: Icon(Icons.person, size: 50, color: Colors.black54),
            ),
            SizedBox(height: 16),
            // Username Field
            buildFixedSizeContainer(context, buildProfileField("dosen", Icons.edit)),
            SizedBox(height: 16),
            // Email Field
            buildFixedSizeContainer(context, buildProfileField("dosen@gmail.com", Icons.edit)),
            SizedBox(height: 16),
            // Password Field
            buildFixedSizeContainer(context, buildProfileField("Password", Icons.edit)),
            SizedBox(height: 16),
            // Bidang Minat Dropdown
            buildFixedSizeContainer(context, buildDropdownField("Bidang Minat")),
            SizedBox(height: 16),
            // Mata Kuliah Dropdown
            buildFixedSizeContainer(context, buildDropdownField("Mata Kuliah")),
            SizedBox(height: 16),
            // Jenis Pengguna Dropdown
            buildFixedSizeContainer(context, buildDropdownField("Jenis Pengguna")),
            Spacer(),
            // Save Button
            ElevatedButton(
              onPressed: () {},
              style: ElevatedButton.styleFrom(
                backgroundColor: Color(0xFFF4D35E), // Warna tombol kuning
                padding: EdgeInsets.symmetric(vertical: 16, horizontal: 32),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
              child: Text(
                "Simpan",
                style: TextStyle(fontSize: 16, color: Colors.black),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // Widget untuk Container dengan ukuran tetap
  Widget buildFixedSizeContainer(BuildContext context, Widget child) {
    return SizedBox(
      height: 60, // Atur tinggi yang sama untuk semua field
      child: Container(
        decoration: BoxDecoration(
          color: Color(0xFF1A2A3A), // Warna latar dalam container
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.white70, width: 1),
        ),
        padding: EdgeInsets.symmetric(horizontal: 12),
        child: child,
      ),
    );
  }

  // Field TextFormField
  Widget buildProfileField(String text, IconData icon) {
    return Row(
      children: [
        Expanded(
          child: TextFormField(
            initialValue: text,
            style: TextStyle(color: Colors.white),
            decoration: InputDecoration(
              border: InputBorder.none,
              suffixIcon: Icon(icon, color: Colors.white70),
            ),
          ),
        ),
      ],
    );
  }

  // Dropdown Field
  Widget buildDropdownField(String hint) {
    return DropdownButtonFormField<String>(
      decoration: InputDecoration(
        border: InputBorder.none,
      ),
      dropdownColor: Color(0xFF1A2A3A),
      style: TextStyle(color: Colors.white),
      hint: Text(hint, style: TextStyle(color: Colors.white70)),
      items: [
        DropdownMenuItem(value: "1", child: Text("Option 1")),
        DropdownMenuItem(value: "2", child: Text("Option 2")),
      ],
      onChanged: (value) {},
    );
  }
}
