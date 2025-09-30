<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;   
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;


   

class PaiementCallbackController extends Controller
{
    
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
            "message" => $transaction->message,
            "ref"     => $transaction->ref // nouvelle référence ajoutée dans la réponse
        ]);
    }

    /**
     * POST : Callback reçu de Suisco
     */
    public function callback(Request $request)
    {
        try {
            Log::info("Callback Paiement reçu", $request->all());

            $idRequete = $request->input("idRequete");
            $code      = $request->input("code");
            $statut    = $request->input("statutRequete");
            $montant   = $request->input("montant");
            $refTmoney = $request->input("refTmoney");

            $transaction = Transaction::where('idRequete', $idRequete)->first();
            if (!$transaction) {
                Log::warning("Transaction inconnue pour idRequete={$idRequete}");
                
            }

           

            // Succès
            if ($statut === "SUCCES" && $code === "2002") {
                $transaction->update([
                    "statut"      => $statut,
                    "code"        => $code,
                    "refCommande" => $transaction->refCommande,
                    "ref"         => $refTmoney ?? $transaction->ref,
                    "message" => $request->input("message", "Paiement reussi"),

                ]);

                Log::info("Paiement enregistré avec succès", [
                    "idRequete" => $idRequete,
                    "statut"      => $statut,
                    "code"        => $code,
                    "refCommande" => $transaction->refCommande,
                    "montant"   => $montant,
                    "ref"       => $refTmoney
                ]);
            
            }

            // Échec
            $transaction->update([
                "statut"  => $statut,
                "code"    => $code,
                "message" => $request->input("message", "Paiement échoué"),
                "ref"     => $refTmoney ?? $transaction->ref
            ]);

            Log::error("Paiement échoué", [
                "idRequete" => $idRequete,
                "code"      => $code,
                "statut"    => $statut,
                "ref"       => $refTmoney
            ]);
            

        } catch (\Exception $e) {
            Log::error("Erreur Callback Paiement : " . $e->getMessage());
            return;
        }
        
    }

}
