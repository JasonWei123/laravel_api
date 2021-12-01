<?php

namespace App\Enums;

class ResponseEnum
{
    // sevming/laravel-response 默认以 '|' 作为分割错误码与错误信息的字符串
    public const REQUEST_SUCCESS = 'code.success|10000';
    public const INVALID_REQUEST = 'code.parameter_error|21001';//前端表单处理
    public const USER_ACCOUNT_REGISTERED = 'code.user_already_exists|23001';
    public const USER_PWD_ERROR = 'code.user_pwd_error|23001';
    public const USER_TOKEN_ERROR = 'code.user_token_error|23002';
    public const REQUEST_MORE = 'code.request_more|30001';
    public const BROADCASTERS_AUTH_FAIL = 'code.broadcasters_auth_fail|40003';
    public const RESPONSE_NO_FOUND = 'code.http_not_found|40004';
    public const RESPONSE_ERROR = 'code.system_error|99999';
}

