<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class GuardSession
{
    public function handle($request, Closure $next, $guard)
    {
        // Set session cookie name per guard before session starts
        Config::set('session.cookie', 'laravel_session_' . $guard);

        return $next($request);
    }
}

