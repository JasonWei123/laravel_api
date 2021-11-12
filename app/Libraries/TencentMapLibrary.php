<?php

namespace App\Libraries;

use \Exception;

class TencentMapLibrary
{
    /**
     * 通过IP获取用户位置信息
     *
     * @param string $ip
     *
     * @return string
     * @throws Exception
     */
    public static function getLocationByIp(string $ip)
    {
        return '福建省厦门市';
    }
}
