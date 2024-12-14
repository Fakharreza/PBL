<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class infoPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'info_pelatihan';
    protected $primaryKey = 'id_info_pelatihan';
    protected $fillable = ['id_info_pelatihan','id_vendor_pelatihan','id_jenis_pelatihan_sertifikasi','id_periode','lokasi_pelatihan','nama_pelatihan','level_pelatihan','tanggal_mulai','tanggal_selesai','kuota_peserta','biaya'];

    public function vendorPelatihan():BelongsTo{
        return $this->belongsTo(VendorPelatihanModel::class, 'id_vendor_pelatihan', 'id_vendor_pelatihan');
    }
    public function jenisPelatihan():BelongsTo{
        return $this->belongsTo(JenisPelatihanModel::class, 'id_jenis_pelatihan_sertifikasi', 'id_jenis_pelatihan_sertifikasi');
    }
    public function periode():BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }
    public function pesertaPelatihan()
    {
        return $this->belongsToMany(penggunaModel::class, 'info_pelatihan_pengguna', 'id_info_pelatihan', 'id_pengguna');
    }

    public function bidangMinat():BelongsTo{
        return $this->belongsTo(bidangMinatPelatihanModel::class, 'id_info_pelatihan ', 'id_info_pelatihan');
    }

    public function mataKuliah():BelongsTo{
        return $this->belongsTo(mataKuliahPelatihanModel::class, 'id_info_pelatihan ', 'id_info_pelatihan');
    }
}
