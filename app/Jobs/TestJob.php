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
        try {
            if($this->user->id==1){
                throw new \Exception(12313);
            }
            info('test:'. $this->user->id.':'.$this->user->num);
            // Code that may throw an Exception or Error.
        }
        catch (\Throwable $t)
        {
            info($t);
            // Executed only in PHP 7, will not match in PHP 5
        }
        catch (\Exception $e)
        {
            info($e);
            // Executed only in PHP 5, will not be reached in PHP 7
        }

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
