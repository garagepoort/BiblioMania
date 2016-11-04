<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PermissionService;

class Permission
{
    /** @var  PermissionService $permissionService*/
    private $permissionService;

    public function handle($request, Closure $next, $permission)
    {
        $this->permissionService = App::make('PermissionService');

        if ($this->permissionService->hasUserPermission(Auth::user()->id, $permission))
        {
            return $next($request);
        }

        throw new AuthenticationException;
    }
}
