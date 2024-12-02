<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSertifModel extends Model
{
    use HasFactory;
    
    // Nama tabel yang terkait dengan model ini
    protected $table = 'vendor_sertifikasi'; // Sesuaikan dengan nama tabel Anda di database

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'id_vendor_sertifikasi',
        'nama_vendor',
        'alamat',
        'kota',
        'no_telp',
        'alamat_web',
    ];

    // Tentukan jika kolom menggunakan tipe data selain default
    public $timestamps = true; // Laravel akan otomatis mengelola created_at dan updated_at

    // Jika menggunakan primary key selain id
    protected $primaryKey = 'id_vendor_sertifikasi';
}