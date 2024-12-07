<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPelatihanModel extends Model
{
    use HasFactory;
    
    protected $table = 'vendor_pelatihan';
    protected $primaryKey = 'id_vendor_pelatihan';
    protected $fillable = ['id_vendor_pelatihan','nama_vendor', 'alamat','kota','no_telp','alamat_web'];

    public function infoPelathian(): BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_vendor_pelatihan', 'id_vendor_pelatihan');
    }
}
