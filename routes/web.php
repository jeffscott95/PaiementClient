<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\TmoneyController;
use App\Http\Controllers\RegisterController;


// Inscription
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Connexion (existant)
Route::get('/login', function () {
    return view('login');
})->name('login');




//WELCOME
Route::get('/', function () {
    return view('welcome');


    // login
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/login', [ConnectController::class, 'show']);
Route::post('/login', [ConnectController::class, 'login']);
Route::get('/logout', [ConnectController::class, 'logout']);

Route::get('/paiement', function() {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
    return "Bienvenue " . session('username');
});

// deconnection
Route::get('/logout', function() {
    session()->flush();
    return redirect('/login');

    // paiement
});
Route::get('/paiement', function() {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
    return view('paiement'); // Vue paiement.blade.php
});


// Page du formulaire paiement
Route::get('/paiement', [TmoneyController::class, 'formPaiement'])->name('paiement.form');

// Lancer un paiement
Route::post('/paiement', [TmoneyController::class, 'initPaiement'])->name('paiement.init');

// Callback Suisco (endpoint public)
Route::post('/tmoney/callback', [TmoneyController::class, 'callback'])->name('tmoney.callback');

// Vérification transaction
Route::get('/transaction/{idRequete}', [TmoneyController::class, 'checkTransaction']);





