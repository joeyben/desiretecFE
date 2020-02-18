<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Exceptions\GeneralException;
use App\Exceptions\WhitelabelException;
use App\Helpers\Auth\Auth;
use App\Helpers\Frontend\Auth\Socialite;
use App\Http\Controllers\Controller;
use App\Http\Utilities\NotificationIos;
use App\Http\Utilities\PushNotification;
use App\Services\Flag\Src\Flag;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var \App\Http\Utilities\PushNotification
     */
    protected $notification;

    /**
     * @param NotificationIos $notification
     */
    public function __construct(PushNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (access()->allow('view-backend')) {
            return route('admin.dashboard');
        } elseif (access()->user()->hasRole('Seller')) {
            return route('frontend.wishes.list', [$subdomain]);
        }

        return route('frontend.index');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm($subdomain)
    {
        return view('frontend.auth.login', compact('subdomain'))
            ->withSocialiteLinks((new Socialite())->getSocialLinks());
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        try {
            return $this->authenticated($request, $this->guard()->user());
        } catch (WhitelabelException $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @param $user
     *
     * @throws GeneralException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        /*
         * Check to see if the users account is confirmed and active
         */
        if (($user->hasRole(Flag::SELLER_ROLE) || $user->hasRole(Flag::EXECUTIVE_ROLE)) && !$user->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            $whitelabel = $user->whitelabels()->first();
            if (null !== $whitelabel && ($whitelabel->name !== getCurrentWhiteLabelField('name'))) {
                access()->logout();
            }

            throw WhitelabelException::mismatchException();
        } elseif (!$user->isConfirmed()) {
            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.resend', ['user_id' => $user->id]), true);
        } elseif (!$user->isActive()) {
            access()->logout();

            throw new GeneralException(trans('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));
        /*
        // Push notification implementation

        $deviceToken    =   "3694d3a6b7258dd6653c6ec0d8488e5fc38577a164af4365b12e5fc0106cc705";
        $message        =   "Testing from php department";
        $sendOption     =   array('Type' => 'Quote');
        $this->notification->_pushNotification($message, 'ios', $deviceToken);
        */
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        /*
         * Boilerplate needed logic
         */

        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Remove any session data from backend
         */
        app()->make(Auth::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($this->guard()->user()));

        /*
         * Laravel specific logic
         */
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        //If for some reason route is getting hit without someone already logged in
        if (!access()->user()) {
            return redirect()->route('frontend.auth.login');
        }

        //If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            //Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            //Re-login admin
            access()->loginUsingId((int) $admin_id);

            //Redirect to backend user page
            return redirect()->route('admin.access.user.index');
        }
        app()->make(Auth::class)->flushTempSession();

        //Otherwise logout and redirect to login
        access()->logout();

        return redirect()->route('frontend.auth.login');
    }
}
