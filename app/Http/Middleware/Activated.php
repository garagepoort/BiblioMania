<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PermissionService;
use ResponseCreator;

class Activated
{
    public function handle($request, Closure $next)
    {

        if (Auth::user()->activated)
        {
            return $next($request);
        }

        return ResponseCreator::createUnauthorizedResponse();
    }
}
