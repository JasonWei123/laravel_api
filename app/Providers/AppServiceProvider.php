<?php

namespace App\Providers;

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
    }
}
