<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpnameDetail extends Model
{
    use HasFactory;

    protected $table = 'opname_detail';

    protected $fillable = [
        'opname_id',
        'aset_id',
        'status_fisik',
        'lokasi_id',
        'karyawan_id',
        'catatan',
        'user_id',
    ];

    /**
     * ======================
     * RELATIONSHIPS
     * ======================
     */

    // Detail milik satu opname
    public function opname()
    {
        return $this->belongsTo(Opname::class);
    }

    // Detail mengacu ke aset
    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiAset::class, 'lokasi_id');
    }

    // Karyawan yang memegang aset
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // User yang input hasil opname
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
