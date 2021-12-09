<?php

namespace App\Http\Controllers;

use App\Enums\ResponseEnum;
use App\Events\UserLogined;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\ResponseSystemException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('pre_jwt', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['account', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            throw new ResponseSystemException(ResponseEnum::USER_PWD_ERROR);
        }
        $payload = auth('api')->payload();
        dd($payload);
        $payload['jti']; // = 'asfe4fq434asdf'
        $return = [
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
        event(new UserLogined(auth('api')->user()));
        return $this->success($return);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $this->success(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->success();
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->success(auth('api')->refresh());
    }

}

