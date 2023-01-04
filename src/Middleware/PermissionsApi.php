<?php

namespace Zainburfat\Rbac\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionsApi
{
    public function handle(Request $request, Closure $next)
    {
        $temp = Str::of($request->route()->getActionName())->afterLast('\\')->split('[@]');
        $scope = (string)Str::of($temp[0])->lower()->remove('controller')->append(' '.$temp[1])->slug('.');

        if (!$request->user()->tokenCan($scope)) {
            return response()->json(['message' => 'unauthenticated']);
        }

        return $next($request);
    }
}
