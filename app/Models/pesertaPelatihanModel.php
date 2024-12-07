<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pesertaPelatihanModel extends Model
{
    use HasFactory;
    protected $table = 'peserta_pelatihan';
    protected $primaryKey = 'id_peserta_pelatihan';
    protected $fillable = ['id_peserta_pelatihan','id_pengguna','id_info_pelatihan','id_surat_tugas' , 'status_acc'];

    public function infoPelatihan():BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_info_pelatihan', 'id_info_pelatihan');

    }
    
    public function pengguna():BelongsTo{
        return $this->belongsTo(penggunaModel::class, 'id_pengguna', 'id_pengguna');

    }
    
    
}
