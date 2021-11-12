<?php

namespace App\Http\Middleware;

use Closure;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        $log = storage_path('logs/request.log');

        $input = $request->all();

        $str = "========================================================================================\n\r"
            . '[' . date('Y-m-d H:i:s') . ']' . $request->ip() . '------->' . $request->path() . "\n\r" . '[paras]' . json_encode($input, 320) . "\n\r";
        file_put_contents($log, $str, FILE_APPEND);
        if (filesize($log) > 1024 * 1024) {
            $bak = storage_path('logs/' . date('YmdHis') . '.bak');
            rename($log, $bak);
        }
        return $next($request);
    }


}
