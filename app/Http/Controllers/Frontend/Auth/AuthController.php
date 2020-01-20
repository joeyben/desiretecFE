<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\ApiAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\TokenRequest;
use Illuminate\Http\Request;
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

            return redirect()->route('frontend.index')->with(['success' => 'Login erfolgreich.']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => 'UngÜltige Zugangsdaten! Bitte erneut versuchen']);
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
            return redirect()->back()->withErrors(['message' => 'UngÜltige Zugangsdaten! Bitte erneut versuchen']);
        }
    }

    public function token (TokenRequest $request, string $token)
    {
        try {

            ApiAuth::byToken($token, $request->get('email'));

            return redirect('/')->with(['success' => 'Logout erfolgreich.']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => 'UngÜltige Zugangsdaten! Bitte erneut versuchen']);
        }
    }

    public function logout ()
    {
        try {
            ApiAuth::logout();

            return redirect()->route('frontend.index')->with(['success' => 'Logout erfolgreich.']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }
}
