<?php

namespace App\Http\Middleware;

use Closure;

class AdminControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!isAdmin()) {
            return response("Unauthorized Access",401);
        }
        return $next($request);
    }
}
