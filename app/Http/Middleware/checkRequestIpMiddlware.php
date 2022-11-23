<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class checkRequestIpMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info($request -> ip());
        if(
            $request -> ip() === env('ALLOWED_IP_ADDRESS_1') ||
            $request -> ip() === env('ALLOWED_IP_ADDRESS_2') ||
            $request -> ip() === env('ALLOWED_IP_ADDRESS_3') ||
            $request -> ip() === env('ALLOWED_IP_ADDRESS_4') ||
            $request -> ip() === env('ALLOWED_IP_ADDRESS_5') ||
            $request -> ip() === env('ALLOWED_IP_ADDRESS_6') 
        ){
            return $next($request);
        } else {
            return response() -> json([
                'error' => 'unauthorised'
            ], 401);
        }

    }
}
