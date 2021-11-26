<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Middleware\RateLimited;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $lock_key_pre = 'TestJob:lock:';
    public $lock_key;

    public $timeout = 30;
    public $tries = 0;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
        $this->lock_key = $this->lock_key_pre . $user->id;
    }

    public function middleware()
    {
        return [new RateLimited];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        info('test:'. $this->user->id.':'.$this->user->num);
    }

    public function tags()
    {
        return ['render', 'test:'. $this->user->id.':'.$this->user->num];
    }

    public function id()
    {
        return ['render', 'test:'. $this->user->id.':'.$this->user->num];
    }
}
