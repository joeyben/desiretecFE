<?php


namespace App;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

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

        $response = $client->post(env('API_URL') . '/api/v1/auth/login', [
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        $token = json_decode($response->getBody(), true)['access_token'];
        $client = new Client();

        $response = $client->post(env('API_URL') . '/api/v1/auth/me',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]
        );

        $result['user'] = json_decode($response->getBody(), true)['user'];

        $result['user']['token'] = $token;

        return static::auth(new ApiUser($result['user']));
    }

    public static function retrieveUser(string $token): ApiUser
    {
        $client = new Client();

        $response = $client->post(env('API_URL') . '/api/v1/auth/me',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]
        );

        $result['user'] = json_decode($response->getBody(), true)['user'];

        $result['user']['token'] = $token;

        return new ApiUser($result['user']);
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
        $client = new Client();

        $response = $client->post(env('API_URL') . '/api/v1/auth/check/role',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . resolve('token')
                ],
                'form_params' => [
                    'role' => $role
                ]
            ]
        );

        return json_decode($response->getBody(), true)['role'];
    }
}
