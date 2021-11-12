<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{
    protected $autoValidate = false;
    protected $onlyRule = [];

    public function rules()
    {
        return [
            'account' => 'required|string|email|min:6|max:60',
            'password' => 'required|string|min:6',
            'telphone' => 'required|zztelphone|min:6',
        ];
    }

    public function scene()
    {
        return [
            'register' => [
                'account',
                'password',
                'telphone',
            ],
            'login' => [
                'account',
                'password',
            ],
            'telphone' => [
                'telphone',
            ],
        ];
    }
}
