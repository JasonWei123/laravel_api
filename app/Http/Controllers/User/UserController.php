<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Enums\ResponseEnum;
use App\Http\Requests\User\UserRequest;


class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function register(UserRequest $request)
    {
        $request->validate('register');
        $params = collect($request->all())->only(
            [
                'account',
                'password',
            ]
        )->toArray();
        $user = $this->service->createUser($params);
        return $this->success($user);
    }


    public function first(Request $request)
    {
        $user = User::all()->toArray();
        return $this->success($user);
    }

    public function update(Request $request)
    {
        $user = User::query()->first();
        $user->account = 'test11111' . time();
        $user->password = 'testaa' . time();
        $user->save();
        return $this->success($user);
    }
}

