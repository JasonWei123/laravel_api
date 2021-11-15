<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $langs = ['Asia/Shanghai' => 'zh-CN', 'America/Los_Angeles' => 'en'];
        // 获取路由前缀
        $local = $request->header('language', 'zh-CN');
        if (in_array($local, $langs)) {
            app()->setLocale($local);
            config(['app.timezone' => array_search($local, $langs)]);
        }
        return $next($request);
    }
}
