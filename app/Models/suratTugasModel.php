<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class suratTugasModel extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';
    protected $primaryKey = 'id_surat_tugas';
    protected $fillable = ['id_surat_tugas','id_peserta_pelatihan','id_peserta_sertifikasi' , 'nama_surat_tugas' ,'file_surat_tugas'];

    public function pesertaPelatihan():BelongsTo{
        return $this->belongsTo(pesertaPelatihanModel::class, 'id_peserta_pelatihan', 'id_peserta_pelatihan');

    }
    
    public function pesertaSertifikasi():BelongsTo{
        return $this->belongsTo(pesertaSertifikasiModel::class, 'id_peserta_sertifikasi', 'id_peserta_sertifikasi');

    }

}
