<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bidangMinatSertifikasiModel extends Model
{
    use HasFactory;
    
    protected $table = 'bidang_minat_sertifikasi';
    protected $primaryKey = 'id_bidang_minat_sertifikasi';
    protected $fillable = ['id_bidang_minat_sertifikasi','id_bidang_minat','id_info_sertifikasi'];

    public function infoSertifikasi():BelongsTo{
        return $this->belongsTo(infoSertifikasiModel::class, 'id_info_sertifikasi', 'id_info_sertifikasi');

    }
    public function bidangMinat():BelongsTo{
        return $this->belongsTo(BidangMinatModel::class, 'id_bidang_minat ', 'id_bidang_minat');
    }
}
