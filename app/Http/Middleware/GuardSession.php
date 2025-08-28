<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GuardSession
{
    public function handle(Request $request, Closure $next)
    {
        // Before login, we don’t know the guard, so default session
        Config::set('session.cookie', 'laravel_session');

        return $next($request);
    }

    /**
     * Call this after login to set a cookie per user type
     */
    public static function setCookieByRole(string $role)
    {
        Config::set('session.cookie', 'laravel_session_' . $role);
    }
}
