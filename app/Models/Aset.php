<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset';

    protected $fillable = [
        'kode_aset',
        'gambar',
        'nama_aset',
        'merek',
        'deskripsi',
        'tgl_penambahan',
        'kategori_id',
        'lokasi_id',
        'karyawan_id',
    ];

    protected $casts = [
        'tgl_penambahan' => 'date',
    ];

    /**
     * RELATIONS
     */

    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiAset::class, 'lokasi_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
