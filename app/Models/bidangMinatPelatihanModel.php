<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bidangMinatPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'bidang_minat_pelatihan';
    protected $primaryKey = 'id_bidang_minat_pelatihan';
    protected $fillable = ['id_bidang_minat_pelatihan','id_bidang_minat','id_info_pelatihan'];

    public function infoPelatihan():BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_info_pelatihan', 'id_info_pelatihan');

    }
    public function bidangMinat():BelongsTo{
        return $this->belongsTo(BidangMinatModel::class, 'id_bidang_minat ', 'id_bidang_minat');
    }
}
