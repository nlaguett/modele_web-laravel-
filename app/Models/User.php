<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Helper pour vérifier si l'utilisateur est admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper pour vérifier si l'utilisateur est un utilisateur standard
    public function isUser()
    {
        return $this->role === 'utilisateur';
    }
}
