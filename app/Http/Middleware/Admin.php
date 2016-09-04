<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return Response::make('Unauthorized', 401);
        }

        if (Auth::user()->admin == false) {
            return Response::make('Unauthorized', 401);
        }
        return $next($request);
    }
}
