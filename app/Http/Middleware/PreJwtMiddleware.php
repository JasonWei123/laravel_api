<?php

namespace App\Http\Middleware;

use App\Enums\ResponseEnum;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\ResponseSystemException;
use Closure;
use Illuminate\Support\Carbon;

class PreJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $token = auth('api')->getToken();
        $check = auth('api')->check();
        $uri = $request->path();

        if (!$check) {
            throw new ResponseSystemException(ResponseEnum::USER_TOKEN_ERROR);
        }
        $_log = [
            'data' => $request->all(),
            'admin_login_time' => Carbon::now()->toDateTime(),
            'token' => $token,
            'user_id' => auth('api')->user()->id,
        ];
        \Log::info($uri, $_log);
        return $next($request);
    }

}
