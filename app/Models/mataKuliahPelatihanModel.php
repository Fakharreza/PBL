<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mataKuliahPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah_pelatihan';
    protected $primaryKey = 'id_mata_kuliah_pelatihan';
    protected $fillable = ['id_mata_kuliah_pelatihan','id_mata_kuliah','id_info_pelatihan'];

    public function infoPelatihan():BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_info_pelatihan', 'id_info_pelatihan');

    }
    public function mataKuliah():BelongsTo{
        return $this->belongsTo(BidangMinatModel::class, 'id_mata_kuliah ', 'id_mata_kuliah');
    }
}
