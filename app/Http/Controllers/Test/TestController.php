<?php

namespace App\Http\Controllers\Test;

use App\Events\ShippingStatusUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\TestJob;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\ResponseEnum;
use App\Http\Requests\User\UserRequest;


class TestController extends Controller
{
    public function test()
    {
//        $user = User::query()->find(1);
        $start = 0;
        $user = new \stdClass();
        $user->id = 1;
        for ($x = $start+1; $x <= $start+50; $x++) {
            $user->num = $x;
            if ($x % 2 == 0) {
                TestJob::dispatch($user)->onQueue('high');
            } else {
                TestJob::dispatch($user)->onQueue('low');
                return $this->success();
            }

        }

//        $user->id = 2;
//        for ($x = $start+51; $x <= $start+60; $x++) {
//            $user->num = $x;
//            if ($x % 2 == 0) {
//                TestJob::dispatch($user);
//            } else {
//                TestJob::dispatch($user);
//            }
//
//        }
        return $this->success();
    }

    public function test1()
    {
        $user = new \stdClass();
        $user->id = 1;
        $user->num = 88;
        TestJob::dispatchNow($user);
        return $this->success();
    }

    public function returnSuccess()
    {
        return $this->ok();
    }

    public function returnFail()
    {
        sleep(30);
        return $this->success();
    }
}

