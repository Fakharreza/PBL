<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mataKuliahDosenModel extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah_dosen';
    protected $primaryKey = 'id_mata_kuliah_dosen';
    protected $fillable = ['id_mata_kuliah_dosen', 'id_pengguna', 'id_mata_kuliah'];

    public function mataKuliah()
    {
        return $this->belongsTo(mataKuliahModel::class, 'id_mata_kuliah');
    }
}
