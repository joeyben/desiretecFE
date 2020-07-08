<?php

namespace App\Http\Middleware;

use App\Services\Api\ApiService;
use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        $subDomain = self::getSubDomain();

        try {
            $whitelabel = Cache::rememberForever(static::getCacheKey($subDomain), function () use ($subDomain) {
                $api = resolve(ApiService::class);
                $whitelabel = $api->getWlInfo($subDomain);
                return $whitelabel;
            });

            session()->put('wl-id', $whitelabel->id);
        } catch (\Exception $e) {
            dd($e->getResponse()->getBody(true)->getContents());
            echo json_decode($e->getResponse()->getBody(true)->getContents())->error->message . ' ' . URL::current() . '<br/><br/>';
            echo 'If not contact your support info@desiretec.com';
            die();
        }


        \View::share('subdomain', $request->route('subdomain'));

        return $next($request);
    }

    public static function getSubDomain(): string
    {
        $parts = explode('.', URL::current());
        $subDomain = str_replace('https://','', $parts[0]);

        return str_replace('http://','', $subDomain);
    }

    public static function getName(): string
    {
        return Str::studly(self::getSubDomain());
    }

    public static function getCacheKey(string $subDomain): string
    {
        return "desiretec.whitelabel.{$subDomain}";
    }

    public static function whitelabelFromCache()
    {
        return json_decode(json_encode(Cache::get(self::getCacheKey(self::getSubDomain()))), true);
    }
}
