<?php

namespace App\Enums;

class ResponseEnum
{
    // sevming/laravel-response 默认以 '|' 作为分割错误码与错误信息的字符串
    public const REQUEST_SUCCESS = 'code.success|10000';
    public const INVALID_REQUEST = 'code.parameter_error|21001';//前端表单处理
    public const USER_ACCOUNT_REGISTERED = 'code.user_already_exists|23001';
    public const RESPONSE_NO_FOUND = 'code.http_not_found|40004';
    public const RESPONSE_ERROR = 'code.system_error|99999';
}

