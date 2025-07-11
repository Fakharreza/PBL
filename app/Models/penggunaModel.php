<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use App\Models\jenisPenggunaModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class penggunaModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $fillable = ['id_jenis_pengguna', 'nama_pengguna','nama', 'password', 'email' , 'nip'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];
    
    public function jenisPengguna(): BelongsTo{
        return $this->belongsTo(jenisPenggunaModel::class, 'id_jenis_pengguna', 'id_jenis_pengguna');
    }
    public function pesertaPelatihan(): BelongsTo{
        return $this->belongsTo(pesertaPelatihanModel::class, 'id_pengguna', 'id_pengguna');
    }
    public function dataSertifikasi(): HasMany{
        return $this->hasMany(DataSertifikasiModel::class, 'id_pengguna', 'id_pengguna');
    }
    public function bidangMinat()
    {
        return $this->hasMany(bidangMinatDosenModel::class, 'id_pengguna');
    }

    public function mataKuliah()
    {
        return $this->hasMany(mataKuliahDosenModel::class, 'id_pengguna');
    }
    
    public function getRoleName(): string
    {
        return $this->jenisPengguna->nama_jenis_pengguna;
    }
    public function hasRole($role): bool
    {
        return $this->jenisPengguna->kode_jenis_pengguna == $role;
    }
    
    public function getRole()
    {
        return $this->jenisPengguna->kode_jenis_pengguna;
    } 
}