<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class BookApi
{
    public function handle($request, Closure $next)
    {
        $apiAuthenticationService = App::make('ApiAuthenticationService');
        $error = $apiAuthenticationService->checkUserAuthenticated();
        if($error != null){
            return $error;
        }
        return $next($request);
    }
}
