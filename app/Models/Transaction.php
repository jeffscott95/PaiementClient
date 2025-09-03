<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'idRequete', 'refCommande', 'numeroClient',
        'montant', 'description', 'statut', 'message'
    ];
}

