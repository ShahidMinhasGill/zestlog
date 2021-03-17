<?php

namespace App\Http\Middleware;

use Closure;

class SecureKey
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
        $secureKey = getenv('SECURE_KEY');
        $headers = apache_request_headers();
        $isAccess = false;
        if (!empty($headers['secure_key']) && $secureKey == $headers['secure_key']) {
            $isAccess = true;
        }
        if (empty($isAccess)) {
            return response("Unauthorized Access", 401);
        }

        return $next($request);
    }
}
