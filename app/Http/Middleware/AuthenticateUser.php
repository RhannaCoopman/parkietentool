<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateUser extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! $request->user()) {
            return redirect('/');
        }

        return $next($request);
    }
}