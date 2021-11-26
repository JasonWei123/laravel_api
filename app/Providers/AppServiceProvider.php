<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        // todo 自定义验证规则 最好zz开头
        //手机号格式验证
        \Illuminate\Support\Facades\Validator::extend('zztelphone', function ($attribute, $value, $parameters) {
            return preg_match('#^1[34578][0-9]{9}$#', $value);
        });
        //sql
        \DB::listen(function ($query) {
            $sql = $query->sql;
            $bingings = $query->bindings;
            $time = $query->time;
            $log = \Log::channel('sql');
            $log->debug('sql ', compact('sql', 'bingings', 'time'));
            //$log->debug(Str::replaceArray('?', $bingings, $sql));
        });

        Queue::before(function (JobProcessing $event) {
            $connectionName = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();
            $log = \Log::channel('job');
            $log->debug('JobProcessing', compact('connectionName', 'job', 'payload'));
        });

        Queue::after(function (JobProcessed $event) {
            $connectionName = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();
            $log = \Log::channel('job');
            $log->debug('JobProcessed', compact('connectionName', 'job', 'payload'));
        });

        Queue::failing(function (JobFailed $event) {
            $connectionName = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();
            $log = \Log::channel('job');
            $log->error('JobFailed', compact('connectionName', 'job', 'payload'));
        });
    }
}
