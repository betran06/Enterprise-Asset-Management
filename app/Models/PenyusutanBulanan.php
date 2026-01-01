<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyusutanBulanan extends Model
{
    use HasFactory;

    protected $table = 'penyusutan_bulanan';

    protected $fillable = [
        'aset_id',
        'periode',
        'metode',
        'beban_bulan',
        'akumulasi_sd_bulan',
        'nilai_buku_akhir',
        'user_id',
        'dibuat_pada',
    ];

    protected $casts = [
        'periode' => 'date',
        'beban_bulan' => 'decimal:2',
        'akumulasi_sd_bulan' => 'decimal:2',
        'nilai_buku_akhir' => 'decimal:2',
        'dibuat_pada' => 'datetime',
    ];

    /**
     * Relasi ke Aset
     */
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    /**
     * User (Admin / Manager) yang menjalankan penyusutan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
