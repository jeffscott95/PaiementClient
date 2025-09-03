<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;


class PaiementCallbackController extends Controller
{
    /**
     * GET : Vérification d'une transaction via ID
     */
    public function getStatus(Request $request)
    {
        $idRequete = $request->query('idRequete');
        if (!$idRequete) {
            return response()->json(["success" => false, "message" => "ID manquant"], 400);
        }

        $transaction = Transaction::where('idRequete', $idRequete)->first();
        if (!$transaction) {
            return response()->json(["success" => false, "message" => "Transaction introuvable"], 404);
        }

        return response()->json([
            "success" => true,
            "status"  => $transaction->statut,
            "message" => $transaction->message
        ]);
    }

   
    public function callback(Request $request)
    {
        try {
            Log::info("Callback Paiement reçu", $request->all());

            
            $idRequete = $request->input("idRequete");
            $code      = $request->input("code");
            $statut    = $request->input("statutRequete");
            $montant   = $request->input("montant");
            $refTmoney = $request->input("refTmoney");

            if (!$idRequete || !$code) {
                return response()->json(["success" => false, "message" => "Requête invalide"], 400);
            }

            $transaction = Transaction::where('idRequete', $idRequete)->first();
            if (!$transaction) {
                return response()->json(["success" => false, "message" => "Transaction inconnue"], 404);
            }

            // Empêche la double exécution
            if ($transaction->statut === "completed") {
                return response()->json(["success" => true, "message" => "Déjà traité"]);
            }

            // Succès
            if ($statut === "SUCCES" && $code === "2002") {
                $transaction->update([
                    "statut"      => "completed",
                    "code"        => $code,
                    "refCommande" => $refTmoney ?? $transaction->refCommande,
                    "message"     => "Paiement confirmé"
                ]);

                return response()->json(["success" => true, "message" => "Paiement enregistré"]);
            }

            // Échec
            $transaction->update([
                "statut"  => "failed",
                "code"    => $code,
                "message" => $request->input("message", "Paiement échoué")
            ]);

            return response()->json(["success" => true, "message" => "Paiement échoué"]);

        } catch (\Exception $e) {
            Log::error("Erreur Callback Paiement : " . $e->getMessage());
            return response()->json(["success" => false, "message" => $e->getMessage()], 500);
        }
    }
}
