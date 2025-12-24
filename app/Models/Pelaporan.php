<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'aset_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: pelaporan milik satu aset
     */
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    /**
     * Relasi: pelaporan dibuat oleh user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: pelaporan dapat punya banyak feedback
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'pelaporan_id');
    }
}
