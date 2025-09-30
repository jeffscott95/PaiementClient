<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // DEBUG: loguer les informations de session pour voir ce qu'il y a
        Log::info('CheckUserSession - session:', session()->all());

        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Veuillez vous connecter.');
        }

        return $next($request);
    }
}
