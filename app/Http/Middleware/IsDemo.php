<?php

namespace App\Http\Middleware;

use Closure;

class IsDemo
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
        if(env('APP_ENV') == 'DEMO'){
            return response()->json(['status' => true, 'message' => __('This is a demo version! You can get full access after purchasing the application.')]);
        }else{
            return $next($request);
        }
    }
}
