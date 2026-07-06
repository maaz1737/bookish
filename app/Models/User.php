<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'mobile', 'email', 'role', 'password', 'is_blocked', 'mobile_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'is_blocked'         => 'boolean',
        'password'           => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
}
