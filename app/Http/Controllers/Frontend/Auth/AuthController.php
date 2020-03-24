<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\ApiAuth;
use App\Http\Controllers\Controller;
use App\Http\Middleware\WhitelabelMiddleware;
use App\Http\Requests\LinkRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\TokenRequest;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ResetPasswordRequest;
use App\Services\Api\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * Class ForgotPasswordController.
 */
class AuthController extends Controller
{
    public function login (LoginRequest $request)
    {
        try {
            $user = ApiAuth::byCredentials($request->get('email'), $request->get('password'));

            return redirect()->route('frontend.index');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function link (LinkRequest $request)
    {
        $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $request->getHttpHost();

        try {
            $response = ApiAuth::loginLink($request->get('email'), $host);

            return redirect()->back()->with(['success' => $response['message']]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors([
                'message' => Lang:: get('alert.whitelabel.missing', ['attribute' => current_whitelabel()['display_name']]),
            ]);
        }
    }

    public function token (TokenRequest $request)
    {
        try {
            ApiAuth::byToken($request->get('token'), $request->get('email'));

            return redirect('/');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function logout ()
    {
        try {
            ApiAuth::logout();
            session()->forget('c-agent');

            return redirect()->route('frontend.index', WhitelabelMiddleware::getSubDomain());
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }

    public function password (LinkRequest $request)
    {
        try {
            $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $request->getHttpHost();

            $response = ApiAuth::passwordResetLink($request->get('email'), $host);

            return redirect()->back()->with(['success' => $response->message]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }

    public function reset (string $subDomain, string $token, string $email)
    {
        ApiAuth::byToken($token, $email);

        return view('frontend.auth.passwords.reset')
            ->withToken($token)
            ->withEmail($email);
    }

    public function changePassword (string $subDomain, ResetPasswordRequest $request)
    {
        try {
            $response = resolve(ApiService::class)->put('/account/resetPassword', $request->all());

            $message = $response->formatResponse('object')->success->message;

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
