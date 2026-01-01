<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DjpKelompok extends Model
{
    use HasFactory;

    protected $table = 'djp_kelompok';

    // karena PK bukan auto increment bigint
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nama',
        'masa_manfaat_tahun',
        'tarif_gl_percent',
        'tarif_sm_percent',
    ];

    /**
     * 1 DJP Kelompok bisa dipakai banyak aset
     */
    public function asetPenyusutanSettings()
    {
        return $this->hasMany(AsetPenyusutanSetting::class, 'djp_kelompok_id');
    }
}
