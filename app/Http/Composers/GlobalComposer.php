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
//        $agents = Agent::where('user_id', $id)->get();

  //      $loggedAvatar = Agent::where('user_id', $id)->where('status', 'Active')->value('avatar');
    //    $loggedAgent = Agent::where('user_id', $id)->where('status', 'Active')->value('display_name');

        $view->with(['logged_in_user' => access()->user()]);
    }
}
