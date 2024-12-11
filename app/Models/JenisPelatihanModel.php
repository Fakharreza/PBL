<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisPelatihanModel extends Model
{
    use HasFactory;
    protected $table = 'jenis_pelatihan_sertifikasi';
    protected $primaryKey = 'id_jenis_pelatihan_sertifikasi';
    protected $fillable = ['id_jenis_pelatihan_sertifikasi','nama_jenis_pelatihan_sertifikasi'];

    public function infoPelathian(): BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_jenis_pelatihan_sertifikasi', 'id_jenis_pelatihan_sertifikasi');
    }
}
