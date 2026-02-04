<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    /**
     * Karena occurred_at bukan created_at default
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'occurred_at',
        'user_id',
        'user_name',
        'action',
        'table_name',
        'row_id',
        'message',
        'before_data',
        'after_data',
        'url',
        'ip_address',
        'http_method',
        'created_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'occurred_at' => 'datetime',
        'before_data' => 'array',
        'after_data'  => 'array',
        'created_at'  => 'datetime',
    ];

    /**
     * User yang melakukan aksi
     * Nullable (jika user sudah dihapus)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
