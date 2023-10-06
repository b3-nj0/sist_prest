<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //return null; 
        //return $request->expectsJson() ? null : response()->json(['error' => 'Unauthorized'], 401);
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

       if (!$request->user()) {
            return response()->json(['error' => 'No te has autenticado!!'], 403);
        }

        return $next($request);
    }
}
