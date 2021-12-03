<?php

namespace App\Http\Controllers\User;

use Algolia\AlgoliaSearch\SearchIndex;
use App\Events\Chat;
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

    public function search(Request $request)
    {
//        $res = User::search('test')->get();
        $res = User::search('福建省',
            function (SearchIndex $algolia, string $query, array $options) {
                $options['query']['bool']['filter']['account'] = [
                    'distance' => 'Martina Legros',
                    'location' => ['lat' => 36, 'lon' => 111],
                ];
                return $algolia->search($query, $options);
            }
        )->get();

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

