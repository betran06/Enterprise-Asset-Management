<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

     // tabel yang digunakan
    protected $table = 'roles';

    // kolom yang bisa diisi
    protected $fillable = [
        'role',
    ];

    // relasi: 1 role punya banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
