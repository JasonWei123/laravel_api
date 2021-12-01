<?php

namespace App\Listeners;

use App\Events\UserLogined;

class UserLoginCountAdd
{
    /**
     * 处理事件
     */
    public function handle(UserLogined $event)
    {
        $event->user->login_count++;
        $event->user->save();
    }
}
