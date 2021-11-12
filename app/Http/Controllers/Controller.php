<?php

namespace App\Http\Controllers;

use App\Enums\ResponseEnum;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $http_success_code = 200;
    public $success_status = 'success';
    public $fail_status = 'fail';
    public $header = ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'];

    public function success($data = [], $exp = [])
    {
        list($massage, $code) = $this->getMessageByCode(ResponseEnum::REQUEST_SUCCESS);
        $return = [
            'status' => $this->success_status,
            'code' => (int)$code,
            'message' => Lang::get($massage),
            'data' => $data,
            'errors' => [],
        ];
        if (!empty($exp)) $return = array_merge($return, $exp);
        return response()->json($return, 200, $this->header)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function failSystem($code)
    {
        list($massage, $code) = $this->getMessageByCode($code);
        $return = [
            'status' => $this->fail_status,
            'code' => (int)$code,
            'message' => Lang::get($massage),
            'data' => [],
            'errors' => [],
        ];
        return response()->json($return, 200, $this->header)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function fail($errors)
    {
        list($massage, $code) = $this->getMessageByCode(ResponseEnum::INVALID_REQUEST);
        $return = [
            'status' => $this->fail_status,
            'code' => (int)$code,
            'message' => Lang::get($massage),
            'data' => [],
            'errors' => $errors,
        ];
        return response()->json($return, $this->http_success_code, $this->header)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function ok()
    {
        return response('ok', $this->http_success_code);
    }

    public function no_ok($msg)
    {
        return response($msg, $this->http_success_code);
    }

    public function getMessageByCode($code)
    {
        return explode('|', $code);
    }
}
