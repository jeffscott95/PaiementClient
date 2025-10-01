<?php  

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use App\Models\Connect;  
use Illuminate\Support\Facades\Hash;  

class ConnectController extends Controller  
{  
    // Afficher le formulaire  
    public function show()  
    {  
        return view('auth.login');  
    }  

    // Traiter la connexion  
    public function login(Request $request)  
    {  
        $request->validate([  
            'phone' => 'required|numeric',  
            'password' => 'required|string',  
        ]);  

        $user = Connect::where('phone', $request->phone)->first();  

        if (!$user || !Hash::check($request->password, $user->password)) {  
            return back()->withErrors(['phone' => 'Numéro de téléphone ou mot de passe incorrect']);  
        }  

        // Sauvegarder la session  
        session([  
            'user_id' => $user->id,  
            'username' => $user->username ?? $user->phone, // fallback au téléphone si pas de username  
        ]);  

        return redirect('/paiement');  
    }  

    // Déconnexion  
    public function logout()  
    {  
        session()->flush();  
        return redirect('/login');  
    }  
}
