<?php

return [
    /**
     * 事件相关
     */
    'event' => [
        /**
         * 监听者
         */
        'listeners' => [
            /**
             * 默认的记录事件
             */
            'App\Events\DefaultLoggable' => [
                'App\Listeners\DefaultLogger',
            ],
        ],

        /**
         * 模型观察者.
         * 以下添加的模型都被ModelObserver监听和观察
         * 后续添加
         */
        'observers' => [
            \App\Models\User::class,
        ],
    ],
];
