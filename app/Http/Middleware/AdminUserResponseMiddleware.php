<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminUserResponseMiddleware
{
    public $time;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $time = null)
    {
        $this->time = $time ?? Carbon::now()->addDay();

        if(Cache::has('getUsers')) {
            return response(Cache::get('getUsers'));
        }

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if(Cache::has('getUsers')) {
            return;
        }

        Cache::put('getUsers', $response->getContent(), $this->time);
    }
}
