<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $configToken = config('app.api_token');

        $request->headers->set('X-API-Token', $configToken);

        return $next($request);
    }
}