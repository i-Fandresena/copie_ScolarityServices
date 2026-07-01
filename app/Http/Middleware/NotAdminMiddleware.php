<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role == 'Licence' || $request->user()->role == 'Master') {
            return $next($request);
        } else {
            Auth::logout();
            abort(403, 'Accès non autorisé, Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    }
}
