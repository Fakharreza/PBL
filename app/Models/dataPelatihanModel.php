<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class dataPelatihanModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'input_pelatihan';

    // Primary key dari tabel
    protected $primaryKey = 'id_input_pelatihan';

    // Kolom yang dapat diisi menggunakan mass assignment
    protected $fillable = [
        'id_jenis_pelatihan_sertifikasi',
        'id_pengguna',
        'id_periode',
        'nama_pelatihan',
        'lokasi_pelatihan',
        'waktu_pelatihan',
        'bukti_pelatihan', // Menyimpan nama file PDF
    ];

    // Casting waktu_pelatihan menjadi format datetime
    protected $casts = [
        'waktu_pelatihan' => 'datetime',
    ];

    /**
     * Relasi dengan model JenisPelatihanModel
     * Menghubungkan input_pelatihan.id_jenis_pelatihan ke jenis_pelatihan.id_jenis_pelatihan
     */
    public function jenisPelatihan(): BelongsTo
    {
        return $this->belongsTo(JenisPelatihanModel::class, 'id_jenis_pelatihan_sertifikasi', 'id_jenis_pelatihan_sertifikasi');
    }    

    /**
     * Relasi dengan model penggunaModel
     * Menghubungkan input_pelatihan.id_pengguna ke pengguna.id_pengguna
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(penggunaModel::class, 'id_pengguna', 'id_pengguna');
    }

    public function periode():BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }

    /**
     * Mengambil nama pengguna dari relasi pengguna
     * Untuk mempermudah akses data nama pengguna tanpa harus query ulang
     */
    public function getNamaPenggunaAttribute(): string
    {
        return $this->pengguna ? $this->pengguna->nama_pengguna : '-';
    }
}