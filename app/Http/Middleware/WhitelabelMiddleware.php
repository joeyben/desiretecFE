<?php

namespace App\Http\Middleware;

use App\Services\Api\ApiService;
use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

class WhitelabelMiddleware
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
        $url_arr = explode('.', URL::current());
        $subdomain_str = str_replace(env ('API_HTTP_LOCAL', 'https://'),'', $url_arr[0]);
        $cachedWhitelabel = Cache::get( 'whitelabel' );

        if((!$cachedWhitelabel || strtolower($cachedWhitelabel->name) !=  $subdomain_str)){
            $api = resolve(ApiService::class);
            $whitelabel = $api->getWlInfo($subdomain_str);
            Cache::forever( 'whitelabel', $whitelabel);
        }
        return $next($request);
    }
}
