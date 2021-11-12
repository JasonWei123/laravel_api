<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Observers\ModelObserver;

class PowerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEvents();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * 执行配置文件
     */
    public function registerEvents()
    {
        $allListeners = config('power.event.listeners');
        if($allListeners){
            foreach ($allListeners as $event => $listeners) {
                foreach ($listeners as $listener) {
                    Event::listen($event, $listener);
                }
            }
        }


//        $subscribers = config('power.event.subscribers');
//        if($subscribers){
//            foreach ($subscribers as $subscriber) {
//                Event::subscribe($subscriber);
//            }
//        }

        $observers = config('power.event.observers');
        if (!empty($observers)) {
            foreach ($observers as $observer) {
                $observer::observe(ModelObserver::class);
            }
        }
    }
}
