<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminOrSelf
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
        $requestedUserId = $request->route()->parameter('id');
        if(
            Auth::user()->role === 2 ||
            Auth::user()->id == $requestedUserId
        ) {
            return $next($request);
        }
        else {
            if ($request->expectsJson()) {
                return response()->json(['error'=>'Unauthorized'], 403);
            } else {
                abort(403);
            }
        }
    }
}
