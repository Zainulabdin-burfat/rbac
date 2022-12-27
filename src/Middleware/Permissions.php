<?php

namespace Zainburfat\Rbac\Middleware;

use Closure;
use Illuminate\Http\Request;

class Permissions
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->hasPermissionTo($request->route()->getName()))
            if (!$request->user()->hasDirectPermissionTo($request->route()->getName()))
                abort(403);

        return $next($request);
    }
}
