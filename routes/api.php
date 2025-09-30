<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaiementCallbackController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/paiement', [PaiementCallbackController::class, 'store']);
    Route::get('/paiement/status', [PaiementCallbackController::class, 'getStatus']);
});

Route::post('/paiement/callback', [PaiementCallbackController::class, 'callback']);

// Route pour obtenir l'utilisateur connecté (via token Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
