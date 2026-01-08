<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;
     protected $table = 'opname';

    protected $fillable = [
        'kode_opname',
        'nama',
        'tanggal_opname',
        'status',
        'user_id',
    ];

    protected $casts = [
        'tanggal_opname' => 'date',
    ];

    /**
     * ======================
     * RELATIONSHIPS
     * ======================
     */

    // Opname dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 opname punya banyak detail aset
    public function details()
    {
        return $this->hasMany(OpnameDetail::class, 'opname_id');
    }

}
