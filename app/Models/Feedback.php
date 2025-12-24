<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'analisis_keputusan',
        'pelaporan_id',
        'status',
        'aset_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: feedback milik satu pelaporan
     */
    public function pelaporan()
    {
        return $this->belongsTo(Pelaporan::class, 'pelaporan_id');
    }

    /**
     * Relasi: feedback milik satu aset (redundant pero migrasi ada)
     */
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    /**
     * Relasi: feedback dibuat oleh user (nullable)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: feedback dapat punya banyak balasan
     */
    public function replies()
    {
        return $this->hasMany(FeedbackReply::class, 'feedback_id');
    }
}
