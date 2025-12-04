<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // =========================
    //     HELPER ROLE
    // =========================

    /** cek 1 role */
    public function hasRole(string $role): bool
    {
        return optional($this->role)->role === $role;
    }

    /** cek role dalam array */
    public function inRoles(array $roles): bool
    {
        return in_array(optional($this->role)->role, $roles, true);
    }

    /** shortcut: user->role_name */
    public function getRoleNameAttribute()
    {
        return optional($this->role)->role;
    }
}
