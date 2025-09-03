<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    use HasFactory;

    protected $table = 'connect'; // nom de ta table
    protected $primaryKey = 'id'; // clé primaire de la table
    public $timestamps = false; // mettre true si tu as created_at/updated_at

    protected $fillable = [
        'username',
        'phone',
        'password', // champs de la table
    ];
}
