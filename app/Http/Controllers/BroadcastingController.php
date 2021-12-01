<?php

namespace App\Http\Controllers;

use App\Enums\ResponseEnum;
use App\Events\UserLogined;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\ResponseSystemException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class BroadcastingController extends Controller
{
    public function auth(Request $request)
    {
        $token = auth('api')->getToken();
        $check = auth('api')->check();

        if (!$check) {
            return response()->json(['auth' => 'error'], 403);
        }
        return $this->ok();
    }


}

