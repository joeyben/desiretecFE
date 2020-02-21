<?php

namespace App\Http\Composers;

use Auth;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $id = Auth::id();
        $currentAgent = session()->get('currentAgent');
        $agentsForSeller = session()->get('agents');

        $user = \Illuminate\Support\Facades\Auth::guard('web')->user() ? \Illuminate\Support\Facades\Auth::guard('web')->user()->user : null;

        if ($user && $user['isSeller'] && !session()->has('currentAgent')) {
            $currentAgent = $user['currentAgent'];
        }

        if ($user && $user['isSeller'] && !session()->has('agents')) {
            $agentsForSeller = $user['agents'];
        }

        $view->with(['logged_in_user' => $user, 'currentAgent' => $currentAgent, 'agentsForSeller' => $agentsForSeller]);
    }
}
