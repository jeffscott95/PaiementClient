<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connect;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Afficher la page d'inscription
    public function create()
    {
        return view('register');
    }

    // Sauvegarder un nouvel utilisateur
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|string|max:50|unique:connect,username',
            'phone' => 'required|string|max:20|unique:connect,phone',
            'password' => 'required|string|min:4',
        ]);

        // Sauvegarde dans la table
        Connect::create([
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Redirection après succès
    return redirect('/login')->with('success', 'Inscription réussie ! Connectez-vous.');
    }
}
