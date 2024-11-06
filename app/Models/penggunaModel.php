<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use App\Models\jenisPenggunaModel;

use Illuminate\Foundation\Auth\User as Authenticatable;

class penggunaModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $fillable = ['id_jenis_pengguna', 'nama_pengguna', 'password', 'email' , 'nip'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];
    
    public function jenisPengguna(): BelongsTo{
        return $this->belongsTo(jenisPenggunaModel::class, 'id_jenis_pengguna', 'id_jenis_pengguna');
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