<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mataKuliahSertifikasiModel extends Model
{
    use HasFactory;
    protected $table = 'mata_kuliah_sertifikasi';
    protected $primaryKey = 'id_mata_kuliah_sertifikasi';
    protected $fillable = ['id_mata_kuliah_sertifikasi','id_mata_kuliah','id_info_sertifikasi'];

    public function infoSertifikasi():BelongsTo{
        return $this->belongsTo(infoSertifikasiModel::class, 'id_info_sertifikasi', 'id_info_sertifikasi');

    }
    public function mataKuliah():BelongsTo{
        return $this->belongsTo(mataKuliahModel::class, 'id_mata_kuliah ', 'id_mata_kuliah');
    }
}
