<?php

namespace App\Services\User;

use App\Enums\ResponseEnum;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\ResponseSystemException;
use \Exception;
use App\Libraries\TencentMapLibrary;
use App\Models\User;

class UserService
{
    /**
     * @param array     $params
     *
     * @return User
     * @throws Exception
     */
    public function createUser(array $params)
    {
        $user = User::findByAccount($params['account']);
        if ($user) {
            throw new ResponseSystemException(ResponseEnum::USER_ACCOUNT_REGISTERED);
        }
        $params['last_ip'] = request()->ip();
        $location = TencentMapLibrary::getLocationByIp($params['last_ip']);
        if (!empty($location)) {
            $params['register_address'] = $location;
        }
        return User::create($params);
    }
}

