<?php

namespace App\Http\Middleware;

use Closure;
/**
 * 验证登录中间件
 * class CheckLogin
 * @author   <[<gaojianbo>]>
 * @package  App\Http\Middleware
 * @date 2019-08-14
 */
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('user')){
            return redirect('login/login');
        }
        return $next($request);
    }
}
