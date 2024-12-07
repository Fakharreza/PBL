<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $primaryKey = 'id_periode';
    protected $fillable = ['id_periode','tahun_periode'];

    public $timestamps = true;

    public function infoPelathian(): BelongsTo{
        return $this->belongsTo(infoPelatihanModel::class, 'id_periode', 'id_periode');
    }
}
