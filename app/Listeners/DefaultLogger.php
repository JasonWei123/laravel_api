<?php

namespace App\Listeners;

use App\Events\DefaultLoggable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class DefaultLogger
{
    /**
     * 处理事件
     */
    public function handle(DefaultLoggable $event)
    {
        $log = [
            'user_id' => $event->userId,
            'title' => $event->title,
            'content' => $event->content,
            'model' => $event->model,
            'model_id' => $event->modelId,
            'uri' => Request::url(),
            'request_data' => Request::all(),
            'created_ip' => Request::ip(),
        ];
        Log::channel('mysql')->info('mysql', $log);
    }
}
