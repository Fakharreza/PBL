<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class notifikasiModel extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = ['id_notifikasi','id_peserta_sertifikasi','id_peserta_pelatihan', 'pesan' , 'is_read'];

    public function pesertaPelatihan():BelongsTo{
        return $this->belongsTo(pesertaPelatihanModel::class, 'id_peserta_pelatihan', 'id_peserta_pelatihan');

    }
    
    public function pesertaSertifikasi():BelongsTo{
        return $this->belongsTo(pesertaSertifikasiModel::class, 'id_peserta_sertifikasi', 'id_peserta_sertifikasi');

    }


}
