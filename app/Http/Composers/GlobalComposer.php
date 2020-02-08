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
        $user = \Illuminate\Support\Facades\Auth::guard('web')->user() ? \Illuminate\Support\Facades\Auth::guard('web')->user()->user : null;
        $view->with(['logged_in_user' => $user]);
    }
}
