<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if(Auth::user()->role >= User::ROLE_EDITOR) {
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
