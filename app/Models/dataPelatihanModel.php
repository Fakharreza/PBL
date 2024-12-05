<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataPelatihanModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pelatihan';

    // Primary key dari tabel
    protected $primaryKey = 'id_pelatihan';

    // Kolom yang dapat diisi menggunakan mass assignment
    protected $fillable = [
        'nama_pelatihan',
        'jenis_pelatihan',
        'waktu_pelatihan',
        'biaya',
        'lokasi_pelatihan',
        'bukti_pelatihan', // Menyimpan nama file PDF
    ];

    // Menambahkan atribut tambahan atau casting jika diperlukan
    protected $casts = [
        'waktu_pelatihan' => 'datetime',
        'biaya' => 'decimal:2',
    ];
}
