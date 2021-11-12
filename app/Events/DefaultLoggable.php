<?php

namespace App\Events;

use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;

class DefaultLoggable
{
    use SerializesModels;

    public $title;

    public $content;

    public $userId;

    public $model;

    public $modelId;

    public function __construct(string $title, string $content, $userId = null, $model = null, $modelId = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->userId = $userId ? $userId : (auth('api')->check() ? auth('api')->user()->id : 0);
        $this->model = $model;
        $this->modelId = $modelId;
    }
}
