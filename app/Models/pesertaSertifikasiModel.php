<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pesertaSertifikasiModel extends Model
{
    use HasFactory;
    protected $table = 'peserta_sertifikasi';
    protected $primaryKey = 'id_peserta_sertifikasi';
    protected $fillable = ['id_peserta_sertifikasi','id_pengguna','id_info_sertifikasi' , 'status_acc'];

    public function infoSertifikasi():BelongsTo{
        return $this->belongsTo(infosertifikasiModel::class, 'id_info_sertifikasi', 'id_info_sertifikasi');

    }
    
    public function pengguna():BelongsTo{
        return $this->belongsTo(penggunaModel::class, 'id_pengguna', 'id_pengguna');

    }
    
    
}
