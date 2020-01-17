<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\ApiAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;

/**
 * Class ForgotPasswordController.
 */
class AuthController extends Controller
{
    public function login (LoginRequest $request)
    {
        try {
            ApiAuth::byCredentials('admin@admin.com', '1234');

            return redirect()->route('frontend.index')->with(['success' => 'Login erfolgreich.']);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

    }
}
