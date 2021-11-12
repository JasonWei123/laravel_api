<?php

namespace App\Enums;

class ResponseEnum
{
    // sevming/laravel-response 默认以 '|' 作为分割错误码与错误信息的字符串
    public const REQUEST_SUCCESS = '请求成功|10000';
    public const INVALID_REQUEST = '无效请求|21001';
    public const USER_ACCOUNT_REGISTERED = '账号已注册|23001';
    public const RESPONSE_NO_FOUND = '路由找不到|40004';
    public const RESPONSE_ERROR = '系统异常|99999';
}

