<?php


namespace App;

use App\Services\Api\ApiService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class ApiAuth
 *
 * @package \App
 */
class ApiAuth
{
    public static function byCredentials(string $email, string $password): ApiUser
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/login', [
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        return self::byJwtToken(json_decode($response->getBody(), true)['access_token']);
    }

    public static function loginLink(string $email, string $host)
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/login/email', [
            'form_params' => [
                'email' => $email,
                'host' => $host,
                'whitelabelId' => current_whitelabel()['id'],
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public static function retrieveUser(string $token): ApiUser
    {
        return Cache::rememberForever(static::getCacheKey($token), function () use ($token) {
            $client = new Client();

            $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/me',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'c-agent' => session()->get('c-agent', null)
                    ]
                ]
            );

            $result['user'] = json_decode($response->getBody(), true);

            $result['user']['token'] = $token;

            return new ApiUser($result['user']);
        });
    }

    protected static function auth(ApiUser $user): ApiUser
    {
        static::session($user);
        static::bind($user);
        static::login($user);

        return $user;
    }

    protected static function session(ApiUser $user): void
    {
        session(['token' => $user->token]);
    }

    protected static function bind(ApiUser $user): void
    {
        app()->bind('user', static function () use ($user): ApiUser {
            return $user;
        });

        app()->bind('token', static function (): string {
            return session('token');
        });
    }

    protected static function login(ApiUser $user): void
    {
        Auth::login($user, true);
    }

    public static function hasRole(string $role): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->role === $role;
    }

    public static function logout()
    {
        Auth::logout();
        Cache::forget(static::getCacheKey(session()->get('token')));
        session()->forget('token');
    }

    public static function byWishToken(string $wishId, string $token)
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/login/wish-token/' . $token,
            [
                'form_params' => [
                    'wish_id' => $wishId
                ]
            ]
        );


        return self::byJwtToken(json_decode($response->getBody(), true)['access_token']);
    }

    public static function byWishListToken(string $token)
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/login/wishlist-token/' . $token,
            [
                'form_params' => []
            ]
        );


        return self::byJwtToken(json_decode($response->getBody(), true)['access_token']);
    }

    public static function byToken(string $token, string $email)
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/login/token/' . $token,
            [
                'form_params' => [
                    'email' => $email
                ]
            ]
        );

        return self::byJwtToken(json_decode($response->getBody(), true)['access_token']);
    }

    public static function byJwtToken(string $token)
    {
        $client = new Client();

        $response = $client->post(env('API_URL', 'https://admin.desiretec.com') . '/api/v1/auth/me',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'c-agent' => session()->get('c-agent', null)
                ]
            ]
        );

        $result['user'] = json_decode($response->getBody(), true);

        $result['user']['token'] = $token;

        return static::auth(new ApiUser($result['user']));
    }

    public static function passwordResetLink(string $email, string $host)
    {
        $response =  resolve(ApiService::class)->post('/account/sendResetLinkEmail', [
            'email' => $email,
            'host' => $host
        ]);

        return  $response->formatResponse('object');
    }

    public static function getCacheKey(string $token): string
    {
        return "desiretec.user-loader.{$token}";
    }
}
