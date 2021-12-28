<?php

namespace App\Http\Controllers\User;

use Algolia\AlgoliaSearch\SearchIndex;
use App\Events\Chat;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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
        return $this->success();
    }


    public function first(Request $request)
    {
        $user = User::paginate(3);
        return $this->success(UserResource::collection($user)->response()->getData());
    }

    public function update(Request $request)
    {
        $user = User::query()->first();
        $user->account = '123';
        $user->desc = 'A fresh verification link has been sent to your email address.';
        $user->save();
        return $this->success($user);
    }

    public function search(Request $request)
    {
//        $res = User::search('test')->get();
        $res = User::search('Ms.')->raw();
        dd($res);
        $res = User::search('Ms.')->paginate(10);
        $res = User::search('Ms.')->get();

        return $this->success($res);
    }

    public function message(UserRequest $request)
    {
        $request->validate('message');
        $params = collect($request->all())->only(
            [
                'message',
            ]
        )->toArray();
        event(new Chat(auth('api')->user(), 1, $params['message']));

        return $this->success();
    }
}

