<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPenyusutanSetting extends Model
{
    use HasFactory;

    protected $table = 'aset_penyusutan_setting';

    protected $fillable = [
        'aset_id',
        'djp_kelompok_id',
        'metode',
        'harga_perolehan',
        'nilai_sisa',
        'umur_bulan',
        'is_disposed',
        'tgl_mulai_pakai',
        'alasan_disposed',
        'catatan_disposal',
    ];

    protected $casts = [
        'harga_perolehan' => 'decimal:2',
        'nilai_sisa' => 'decimal:2',
        'is_disposed' => 'boolean',
        'tgl_mulai_pakai' => 'date',
    ];

    /**
     * Relasi ke Aset
     */
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    /**
     * Relasi ke DJP Kelompok
     */
    public function djpKelompok()
    {
        return $this->belongsTo(DjpKelompok::class, 'djp_kelompok_id');
    }
}
