<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$Roles): Response
    {

        // check has no access
        if(auth()->check()){
            $Role = auth()->user()->role;
            $hasAccess = in_array($Role, $Roles);
            if (!$hasAccess) {
                abort(403, 'Unauthorized');
            }
        }

        // has access
        return $next($request);
    }
}
