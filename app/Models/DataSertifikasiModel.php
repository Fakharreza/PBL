<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'input_sertifikasi';
    protected $primaryKey = 'id_input_sertifikasi';
    protected $fillable = ['id_input_sertifikasi', 'id_jenis_pelatihan_sertifikasi', 'id_pengguna', 'id_periode', 'nama_sertifikasi','no_sertifikat', 'lokasi_sertifikasi', 'waktu_sertifikasi' , 'bukti_sertifikasi', 'masa_berlaku'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(penggunaModel::class, 'id_pengguna', 'id_pengguna');
    }

    public function periode():BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }

    public function jenisPelatihan(): BelongsTo
    {
        return $this->belongsTo(JenisPelatihanModel::class, 'id_jenis_pelatihan_sertifikasi', 'id_jenis_pelatihan_sertifikasi');
    }   
}
