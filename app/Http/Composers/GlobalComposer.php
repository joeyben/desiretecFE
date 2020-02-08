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

        $view->with(['logged_in_user' => \Illuminate\Support\Facades\Auth::guard('web')->user()]);
    }
}
