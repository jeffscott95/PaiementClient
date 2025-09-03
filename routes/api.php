<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementCallbackController;   


Route::get('/paiement/status', [PaiementCallbackController::class, 'getStatus']);
Route::post('/paiement/callback', [PaiementCallbackController::class, 'callback']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
