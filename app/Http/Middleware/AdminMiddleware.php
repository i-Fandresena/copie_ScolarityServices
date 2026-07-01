<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role !== 'admin') {
            Auth::logout();
            abort(403, 'Accès non autorisé, seul les administrateurs peuvent accéder à cette page.');
        } else if ($request->user() && $request->user()->role == 'admin') {
            return $next($request);
        }

    }

}
