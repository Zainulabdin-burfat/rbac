<?php

namespace Zainburfat\Rbac\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionsWeb
{
    public function handle(Request $request, Closure $next)
    {
        $temp = Str::of($request->route()->getActionName())->afterLast('\\')->split('[@]');
        $scope = (string)Str::of($temp[0])->lower()->remove('controller')->append(' '.$temp[1])->slug('.');

        if (!$request->user()->tokenCan($scope)) {
            abort(403);
        }

        // if (!$request->user()->hasPermissionTo($request->route()->getName()))
        //     if (!$request->user()->hasDirectPermissionTo($request->route()->getName()))
        //         abort(403);

        return $next($request);
    }
}
