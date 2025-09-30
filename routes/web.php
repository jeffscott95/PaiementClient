<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\TmoneyController;
use App\Http\Controllers\RegisterController;



// Inscription
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Connexion
Route::get('/login', [ConnectController::class, 'show'])->name('login');
Route::post('/login', [ConnectController::class, 'login']);
Route::get('/logout', [ConnectController::class, 'logout'])->name('logout');

// Accueil
Route::get('/', function () {
    return view('welcome');
});

// ✅ Paiement protégé
Route::middleware(['checksession'])->group(function () {
    Route::get('/paiement', [TmoneyController::class, 'formPaiement'])->name('paiement.form');
    Route::post('/paiement', [TmoneyController::class, 'initPaiement'])->name('paiement.init');
});


// ✅ Callback public (pas besoin d'auth)
Route::post('/tmoney/callback', [TmoneyController::class, 'callback'])->name('tmoney.callback');

// ✅ Vérification transaction (protégée si tu veux)
Route::middleware(['auth'])->get('/transaction/{idRequete}', [TmoneyController::class, 'checkTransaction']);



// Protect GET and POST with middleware class directly
Route::get('/paiement', [TmoneyController::class, 'formPaiement'])
    ->middleware(\App\Http\Middleware\CheckUserSession::class)
    ->name('paiement.form');

Route::post('/paiement', [TmoneyController::class, 'initPaiement'])
    ->middleware(\App\Http\Middleware\CheckUserSession::class)
    ->name('paiement.init');
