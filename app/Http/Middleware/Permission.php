<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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

        return Response::json(array(
            'code'      =>  403,
            'message'   =>  'user.does.not.have.right.permissions'
        ), 403);
    }
}
