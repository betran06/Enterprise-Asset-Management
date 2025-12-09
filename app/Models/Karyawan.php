<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'kode_karyawan',
        'nama',
        'departement',
        'jabatan',
    ];

    /**
     * Relasi: 1 karyawan bisa memiliki banyak aset
     */
    public function aset()
    {
        return $this->hasMany(Aset::class, 'karyawan_id');
    }
}
