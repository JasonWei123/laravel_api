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
        $langs = ['zh-CN', 'en', 'th'];
        // 获取路由前缀
        $local = $request->header('language', 'zh-CN');
        if (in_array($local, $langs)) {
            app()->setLocale($local);
        }
        return $next($request);
    }
}
