<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateAdmin extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! $request->user() || $request->user()->role_id !== 1) {
            return redirect('/');
        }

        return $next($request);
    }
}