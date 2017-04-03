<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Log as Logger;
class Log
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
        DB::connection()->enableQueryLog();
        $response = $next($request);
        $queries = DB::getQueryLog();
        Logger::info('db query log: '.json_encode($queries));
        return $response;

    }
}
