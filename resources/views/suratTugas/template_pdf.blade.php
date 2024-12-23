<!DOCTYPE html>
<html>
<head>
    <title>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI POLITEKNIK NEGERI MALANG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
        <p>POLITEKNIK NEGERI MALANG</p>
        <p>Jalan Soekarno Hatta No.9 Jutuwayu, Lowokwaru, Malang, 65141</p>
        <p>Telp. (0341) 404424-404425, Fax. (0341) 404420</p>
        <p>Laman: https://www.polinema.ac.id</p>
    </div>
    <hr>    
    <h3 style="text-align:center">SURAT TUGAS</h3>
    <p style="text-align:center">Nomor: {{ $nomor_surat }}</p> <!-- Nomor Surat Acak -->
    <p>Pimpinan memberikan tugas kepada:</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peserta as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->pengguna->nama }}</td>
                    <td>{{ $item->pengguna->jenisPengguna->nama_jenis_pengguna }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Untuk mengikuti kegiatan <strong>{{ $jenis }} {{ $nama_kegiatan }}</strong> yang diselenggarakan oleh
        <strong>{{ $vendor }}</strong>.</p>
    <p>Kegiatan ini akan berlangsung pada periode <strong>{{ $periode }}</strong>, dimulai dari tanggal
        <strong>{{ \Carbon\Carbon::parse($tanggal_mulai)->format('d F Y') }}</strong>
        sampai dengan <strong>{{ \Carbon\Carbon::parse($tanggal_selesai)->format('d F Y') }}</strong>.</p>

    <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya.</p>
    <br><br><br>
    <p style="text-align: right;">Malang, {{ date('d F Y') }}</p>
    <p style="text-align: right;">Pimpinan,</p>
    <br><br><br><br>
    <p style="text-align: right;"><strong>Dr. Eng. Rosa Andrie Asmara, S.T., M.T</strong></p>
    <p style="text-align: right;">NIP: 19801010200501001</p>
</body>
</html>
