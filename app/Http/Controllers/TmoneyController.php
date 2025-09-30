<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class TmoneyController extends Controller
{
    // Affichage du formulaire de paiement
    public function formPaiement()
    {
        return view('paiement');
    }

    // Initialiser un paiement
    public function initPaiement(Request $request)
    {
        // dd($request->numeroClient);
        $idRequete   = "payclient@" . uniqid();
        $refCommande = "CMD" . time();

        // Sauvegarde en base
        $transaction = Transaction::create([
            'idRequete'    => $idRequete,
            'refCommande'  => $refCommande,
            'numeroClient' => "228" . $request->numeroClient, // ajout indicatif
            'montant'      => $request->montant,
            'description'  => "Paiement commande",
            'statut'       => 'ECHEC',
            'ref'          => null // ajouté : référence externe vide au départ
        ]);

        // Préparation payload pour Suisco
        $payload = [
            "idRequete"       => $idRequete,
            "numeroClient"    => "228" . $request->numeroClient,
            "montant"         => $request->montant,
            "refCommande"     => $refCommande,
            "dateHeureRequete"=> now()->format('Y-m-d H:i:s'),
            "description"     => "Paiement commande"
        ];

        // Appel API Suisco
        $response = Http::post("https://pay.suisco.net/api/push-ussd/tmoney/request", $payload);
        $result   = $response->json();

        // Vérifie le code de retour
        if (isset($result['code']) && $result['code'] == "2000") {
            $transaction->statut = 'EN ATTENTE';
        } else {
            $transaction->statut = 'ECHEC';
        }

        // Mise à jour transaction
        $transaction->update([
            'message' => $result['message'] ?? 'En attente traitement',
            'ref'     => $result['refTmoney'] ?? null // si API renvoie une référence
        ]);

        return response()->json($result);
    }

    // Callback Suisco
    public function callback(Request $request)
    {
        $idRequete = $request->idRequete;

        $transaction = Transaction::where('idRequete', $idRequete)->first();
        if ($transaction) {
            $transaction->update([
                'statut' => $request->statutRequete ?? 'ECHEC',
                'message'=> $request->message,
                'ref'    => $request->refTmoney ?? $transaction->ref // on stocke la ref envoyée par TMoney
            ]);
        }

        return response()->json(["status" => "ok"]);
    }

    // Vérification manuelle d'une transaction
    public function checkTransaction($idRequete)
    {
        $payload  = ["idRequete" => $idRequete];
        $response = Http::post("https://pay.suisco.net/api/push-ussd/tmoney/check-after-callback", $payload);

        return $response->json();
    }
}
