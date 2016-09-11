<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class LocalCallOnly
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
        if (Request::server('SERVER_ADDR') != Request::server('REMOTE_ADDR'))
        {
            return App::abort(404);
        }
        return $next($request);
    }
}
