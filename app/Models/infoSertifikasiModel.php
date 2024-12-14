<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class infoSertifikasiModel extends Model
{
    use HasFactory;
    protected $table = 'info_sertifikasi';
    protected $primaryKey = 'id_info_sertifikasi';
    protected $fillable = ['id_info_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','id_periode','nama_sertifikasi','level_sertifikasi','tanggal_mulai','tanggal_selesai','kuota_peserta','masa_berlaku'];

    public function vendorSertifikasi():BelongsTo{
        return $this->belongsTo(VendorSertifModel::class, 'id_vendor_sertifikasi', 'id_vendor_sertifikasi');
    }

    public function periode():BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }
    public function pesertasertifikasi()
    {
        return $this->belongsToMany(penggunaModel::class, 'info_sertifikasi_pengguna', 'id_info_sertifikasi', 'id_pengguna');
    }
}
