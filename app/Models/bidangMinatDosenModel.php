<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bidangMinatDosenModel extends Model
{
    use HasFactory;

    protected $table = 'bidang_minat_dosen';
    protected $primaryKey = 'id_bidang_minat_dosen';
    protected $fillable = ['id_bidan_minat_dosen', 'id_pengguna', 'id_bidang_minat'];

    public function bidangMinat()
    {
        return $this->belongsTo(bidangMinatModel::class, 'id_bidang_minat');
    }
}
