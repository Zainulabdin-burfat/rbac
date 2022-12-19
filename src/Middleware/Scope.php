<?php

namespace Zainburfat\rbac\Middleware;

use Illuminate\Auth\AuthenticationException;

class Scope
{
    public function handle($request, $next, ...$scopes)
    {
        if (!$request->user() || !$request->user()->token()) {
            throw new AuthenticationException;
        }

        foreach ($scopes as $scope) {
            if ($request->user()->tokenCan($scope)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
