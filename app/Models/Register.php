<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Permet de l'utiliser comme utilisateur

class Register extends Authenticatable
{
    use HasFactory;

    protected $table = 'connect'; // nom de la table

    protected $fillable = [
        'username',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
