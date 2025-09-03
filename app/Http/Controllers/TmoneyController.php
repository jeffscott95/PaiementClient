<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class TmoneyController extends Controller
{
    // Affichage formulaire
    public function formPaiement() {
        return view('paiement');
    }

    // Lancer paiement
    public function initPaiement(Request $request) {
        $idRequete = "payclient@" . uniqid();
        $refCommande = "CMD" . time();

        // Sauvegarde DB
        $transaction = Transaction::create([
            'idRequete' => $idRequete,
            'refCommande' => $refCommande,
            'numeroClient' => $request->numeroClient,
            'montant' => $request->montant,
            'description' => "Paiement commande",
            'statut' => 'ECHEC'
        ]);

        // Requête vers Suisco
        $payload = [
            "idRequete" => $idRequete,
            "numeroClient" => $request->numeroClient,
            "montant" => $request->montant,
            "refCommande" => $refCommande,
            "dateHeureRequete" => now()->format('Y-m-d H:i:s'),
            "description" => "Paiement commande"
        ];

        $response = Http::post("https://pay.suisco.net/api/push-ussd/tmoney/request", $payload);

        $result = $response->json();
    if (isset($result['code']) && $result['code'] == "2000") {
         $transaction->statut = 'EN ATTENTE';
    } else {
        $transaction->statut = 'ECHEC';
    }


        // Mettre à jour statut en fonction du retour
        $transaction->update([
            'message' => $result['message'] ?? 'En attente traitement'
        ]);

        return response()->json($result);
    }

    // Callback Suisco
    public function callback(Request $request) {
        $idRequete = $request->idRequete;

        $transaction = Transaction::where('idRequete', $idRequete)->first();
        if ($transaction) {
            $transaction->update([
                'statut' => $request->statutRequete ?? 'ECHEC',
                'message' => $request->message
            ]);
        }

        return response()->json(["status" => "ok"]);
    }

    // Vérification manuelle
    public function checkTransaction($idRequete) {
        $payload = ["idRequete" => $idRequete];

        $response = Http::post("https://pay.suisco.net/api/push-ussd/tmoney/check-after-callback", $payload);

        return $response->json();
    }


          
}



 