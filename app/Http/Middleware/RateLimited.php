<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * 处理队列中的任务.
     *
     * @param mixed $job
     * @param callable $next
     * @return mixed
     */
    public function handle($job, $next)
    {
        if ($job->lock_key) {
            Redis::throttle($job->lock_key)->block(0)
                ->allow(10)->every(3)
                ->then(function () use ($job, $next) {
                    // 锁定…
                    $next($job);
                }, function () use ($job) {
                    // 无法获取锁…
                    $job->release(5);
                });

//            Redis::funnel($job->lock_key)->limit(1)
//                ->then(function () use ($job, $next) {
//                    $next($job);
//                }, function () use ($job) {
//                    // 无法获得锁...
//                    return $job->release(5);
//                });

        }
    }
}
