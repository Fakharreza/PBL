<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class jenisPenggunaModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_pengguna';
    protected $primaryKey = 'id_jenis_pengguna';
    protected $fillable = ['id_jenis_pengguna','kode_jenis_pengguna', 'nama_jenis_pengguna'];

    public function user(): BelongsTo{
        return $this->belongsTo(penggunaModel::class);
    }
}