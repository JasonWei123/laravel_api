<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class MyThrottle extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function resolveRequestSignature($request)
    {
        if ($user = $request->user()) {
            return sha1($user->getAuthIdentifier());
        }

        if ($route = $request->route()) {
            return sha1($route->getDomain() . '|' . $request->ip() . '|' . $route->uri());
        }

        throw new \RuntimeException('Unable to generate the request signature. Route unavailable.');
    }
}
