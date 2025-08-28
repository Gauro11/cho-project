<?php

// app/Http/Middleware/GuardSession.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class GuardSession
{
    public function handle($request, Closure $next, $guard)
    {
        // Change session cookie name per guard
        Config::set('session.cookie', $guard . '_session');
        return $next($request);
    }
}


